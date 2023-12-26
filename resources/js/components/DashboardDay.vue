<template>
    <li class="bg-block-bg dark:bg-block-bg--dark rounded p-3 xs:p-4 mt-3 first:mt-0 sm:mb-4 cursor-pointer border border-[#f4f4f4] dark:border-block-bg-border--dark" 
        :class="{'day--active': selected}" 
        @click.stop="!selected ?  selectThisDay() : null ">
        <div class="relative flex">
            <div class="flex mx-auto">
                <div class="text-2xl font-bold uppercase">{{ day.title || day.day }}</div>
                <div class="ml-2 flex flex-col justify-around">
                    <div class="text-xs uppercase -mb-2">{{ day.dayWeek }}</div>
                    <div class="text-xs lowercase text-small-text dark:text-small-text--dark">{{ day.month }}</div>
                </div>
            </div>
            <div class="absolute right-0 top-0" v-if="noteSaving">
                <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
            <button v-else-if="!noteSaving && day.text.length > 0" 
                    class="absolute right-0 top-0" 
                    @click.stop="actualNoteData.bookmated = 1 - actualNoteData.bookmated;
                                 save(null, dayIndex)">
                <template v-if="actualNoteData.bookmated">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 xs:w-6 xs:h-6 fill-red-500">
                    <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd" />
                    </svg>
                </template>
                <template v-else>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 xs:w-6 xs:h-6 stroke-slate-300 hover:stroke-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                    </svg>
                </template>
            </button>
        </div>
        <div class="mt-4 overflow-hidden" v-if="day.text || selected">
            <div class="float-left bg-main text-white dark:text-text--dark px-[2px] rounded mr-2 align-middle cursor-pointer"
                 @click.stop="actualNoteData.theday = 1 - actualNoteData.theday;
                              save(null, dayIndex)">
                <button class="flex">
                    <template v-if="actualNoteData.theday">
                        <span class="my-auto mx-1">День, когда</span>
                        <span class="my-auto" v-if="selected">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </span>
                    </template>
                    <template v-else-if="!actualNoteData.theday && selected">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                    </template>
                </button>
            </div>
            <div 
                ref="noteInput"
                class="cursor-text"
                autocapitalize="none"
                spellcheck="false"
                contenteditable="true"
                v-html="day.text + '<br/>'"
                @input="event => save(event, dayIndex)"
            ></div>
        </div>
    </li>
</template>
<script setup>
    import axios from 'axios';
    import { ref, nextTick } from 'vue';

    const props = defineProps(['dayIndex', 'day', 'selected']);
    const emits = defineEmits(['selectThisDay', 'noteDataUpdate', 'updateDays']);
    const noteInput = ref(null);

    let noteSaving = ref(false);
    let saveTimer;
    let actualNoteData = Object.assign({}, props.day);

    //METHODS
    function save(e, dayIndex){
        if(saveTimer) clearTimeout(saveTimer);
        let delayTime = 1500;

        if(e !== null){
            actualNoteData.text = e.target.innerText.trim();
        }
        else delayTime = 0;

        saveTimer = setTimeout(() => {
            noteSaving.value = true;

            axios.post('/notes/createorupdate', {
                text: actualNoteData.text,
                fulldate: actualNoteData.fulldate,
                bookmated: actualNoteData.bookmated,
                theday: actualNoteData.theday
            })
            .finally(() => {
                emits('noteDataUpdate', actualNoteData);

                if(!props.selected) emits('updateDays');
                noteSaving.value = false;
            });
        }, delayTime);    
    }
    function selectThisDay(){
        emits('selectThisDay', props.dayIndex);

        nextTick(() => {
            noteInput.value.focus();
        });
    }
</script>