<template>
    <div class="px-5 pt-4 pb-7 w-[100% + 0px)] ml-[-20px] mr-[-20px] sm:mx-0 bg-mylightgray">
        <div class="relative">
            <div class="day__title mb-4">Today</div>  
            <div class="absolute right-0 top-0" v-if="saving">
                <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
        </div>
        <div class="">
            <div class="float-left bg-main text-white px-[2px] rounded mr-2 align-middle cursor-pointer">
                <button class="flex" @click="data.theday = !data.theday">
                    <template v-if="data.theday">
                        <span class="my-auto ml-1">The day</span>
                        <span class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </span>
                    </template>
                    <template v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
</svg>

                    </template>
                </button>
            </div>
            <div
                class="min-w-[5px] before:text-gray-400"
                contenteditable
                @input="event => save(event, 0)"
                :class="{'placeholder': data.text.length == 0}">
                <div v-once>{{ data.text }}</div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref, reactive } from 'vue';
    let data = ref({
        id: null,
        theday: true,
        text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus amet est repudiandae nemo. Consectetur, illo!'
    });

    let timer;
    const saving = ref(false);
    
    function save(e, id){
        data.value.text = e.target.innerText.trim();
        saving.value = true;

        if(saving.value){
            clearTimeout(timer);
        }
        
        timer = setTimeout(() => {
            // data.id = id;
            saving.value = false;
        }, "3000");     
    }
</script>
<style>
/* /empty:before:content-[dfsafsadfsd] empty:focus:before:content-[]/ */
    .placeholder::before {
        content: 'i was happy';
    }
    .placeholder:focus::before{
        content: '';
    }
</style>