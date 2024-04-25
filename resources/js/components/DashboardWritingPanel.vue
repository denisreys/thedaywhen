<template>
    <div class="w-full bg-white dark:bg-bg--dark p-3 xs:p-4 sm:p-5 pb-2 xs:!pb-3 z-40 border-t border-block-border dark:border-block-border--dark shadow-menu fixed bottom-0 sm:bottom-12">
         <div class="sm:w-[500px] sm:mx-auto flex flex-col">
            <div class="relative flex items-center">
                <div class="flex mx-auto">
                    <div class="text-[28px] leading-none font-semibold uppercase">
                        {{ (!selectedDay.states.today) ? selectedDay.day : 'Сегодня' }}
                    </div>
                    <div class="ml-2 flex flex-col justify-around">
                        <div class="text-xs uppercase -mb-2 font-semibold" :class="{'text-red-300': selectedDay.states.weekend}">
                            {{ selectedDay.dayWeek }}
                        </div>
                        <div class="text-xs lowercase text-small-text dark:text-small-text--dark">
                            {{ selectedDay.month }}
                        </div>
                    </div>
                </div>
                <div class="absolute right-0 top-0">
                    <template v-if="!noteSaving">
                        <button class="text-green-500" @click.stop="save(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </template>
                    <template v-else>
                        <svg class="w-6 h-6 text-small-text dark:text-small-text--dark animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </template>
                </div>
            </div>
            <div class="mt-2 xs:mt-3 max-h-[70vh] overflow-auto">
                <div class="float-left bg-main dark:bg-main--dark text-white dark:!text-text--dark px-[2px] rounded mr-2 align-middle cursor-pointer"
                    @click.stop="actualNoteData.theday = 1 - actualNoteData.theday">
                    <button class="flex">
                        <template v-if="actualNoteData.theday">
                            <span class="my-auto mx-1 leading-5 sm:leading-6">День, когда</span>
                            <span class="my-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                            </span>
                        </template>
                        <template v-else-if="!actualNoteData.theday">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                        </template>
                    </button>
                </div>
                <div 
                    ref="noteInput"
                    class="cursor-text leading-5 sm:leading-6"
                    autocapitalize="none"
                    spellcheck="false"
                    contenteditable="true"
                    v-html="selectedDay.text || '<br>'"
                    @input="updateActualText()"
                    @keydown.enter.prevent="event => insertLineBreak()">
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center pt-2 xs:pt-3 border-t border-block-bg-border dark:border-block-bg--dark">
                <div class="text-xs text-small-text dark:text-small-text--dark" :class="{'opacity-20': noteTextNoHtml.length == 0}">
                    <span class="float-left mr-1" :class="{'text-red-500': noteTextNoHtml.length > 2000}">
                        {{ noteTextNoHtml.length }}
                    </span>
                    <span>из 2000</span>
                </div>
                <ul class="flex float-right opacity-20 text-small-text dark:text-small-text--dark" :class="{'!opacity-100': noteTextNoHtml.length}">
                    <li class="mr-2">
                        <button @click="formattingNote('bold')">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 1h4.5a3.5 3.5 0 1 1 0 7H3m0-7v7m0-7H1m2 7h6.5a3.5 3.5 0 1 1 0 7H3m0-7v7m0 0H1"/>
                            </svg>
                        </button>
                    </li>
                    <li class="mr-2">
                        <button @click="formattingNote('italic')">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3.874 15 6.143-14M1 15h6.33M6.67 1H13"/>
                            </svg>
                        </button>
                    </li>
                    <li class="">
                        <button @click="formattingNote('underline')">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 1v9.5a4.5 4.5 0 1 1-9 0V1M1 1h4m5 0h4M1 19h14"/>
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="days__overlay cursor-pointer" @click="handlerClickOverlay()"></div> 
</template>
<script setup>
    import axios from 'axios';
    import { ref, nextTick, onMounted } from 'vue';
    const emits = defineEmits(['noteDataUpdate', 'updateDays', 'unSelect']);

    const props = defineProps(['selectedDay']);

    const noteInput = ref(null);
    let noteSaving = ref(false);
    let actualNoteData = ref(Object.assign({}, props.selectedDay));
    const noteTextNoHtml = ref(0);

    onMounted(() => {
        noteTextNoHtml.value = noteInput.value.innerText.trim();

        nextTick(() => {
            noteInput.value.focus();
        });
    });

    //METHODS
    function save(){
        noteSaving.value = true;

        axios.post('/notes/createorupdate', {
            text: actualNoteData.value.text,
            fulldate: actualNoteData.value.fulldate,
            bookmated: actualNoteData.value.bookmated,
            theday: actualNoteData.value.theday
        })
        .finally(() => {
            emits('noteDataUpdate', actualNoteData.value);

            if(!props.selected) emits('updateDays');
            noteSaving.value = false;
            emits('unSelect');
        });
    }
    function updateActualText(){
        noteTextNoHtml.value = noteInput.value.innerText;

        if(noteTextNoHtml.value.length <= 2000){
            actualNoteData.value.text = noteInput.value.innerHTML;
        }
    }
    function insertLineBreak(){
        document.execCommand('insertHTML', true, '<br><br>');
    }
    function handlerClickOverlay(){
        const isTheNoteChanged = props.selectedDay.text != actualNoteData.value.text && 
                                 actualNoteData.value.text != '<br>' ||
                                 props.selectedDay.theday != actualNoteData.value.theday;
        if(isTheNoteChanged){
            const response = confirm('Изменения не были сохранены. Нажмите "Ок", чтобы продолжить');

            if(!response) return false;
        }

        emits('unSelect');
    }
    function formattingNote(action){
        const selectedText = window.getSelection().toString();
        
        if(selectedText != ''){
            switch(action){
                case 'bold' : 
                    document.execCommand("bold", false, null);
                    break;
                case 'italic' : 
                    document.execCommand("italic", false, null);
                    break;
                case 'underline' : 
                    document.execCommand("underline", false, null);
                    break;
            }
        }
    }
</script>