<template>
    <li class="bg-block-bg dark:bg-[#2e2e31] rounded-md p-3 xs:p-4 sm:p-4 mt-[5px] sm:mt-2 first:mt-0 cursor-pointer border border-block-bg-border dark:border-[#262629]" 
        @click.stop="emits('selectThisDay', props.dayIndex);">
        <div class="relative flex items-center">
            <marksBlock
                :marks="day.states"
            />
            <div class="flex mx-auto">
                <div class="text-[28px] leading-none font-semibold uppercase">
                    {{ (!day.states.today) ? day.day : 'Сегодня' }}
                </div>
                <div class="ml-2 flex flex-col justify-around">
                    <div class="text-xs uppercase -mb-2 font-semibold" :class="{'text-orange-300': day.states.weekend}">{{ day.dayWeek }}</div>
                    <div class="text-xs lowercase text-small-text dark:text-small-text--dark">{{ day.month }}</div>
                </div>
            </div>
            <button v-if="day.text.length > 0" 
                    class="absolute right-0 top-0" 
                    @click.stop="updateBookmated()">
                <svg v-if="day.bookmated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 xs:w-6 xs:h-6 text-red-500">
                <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 xs:w-6 xs:h-6 text-small-text dark:text-small-text--dark">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
            </button>
        </div>
        <div class="mt-2 xs:mt-3 overflow-hidden leading-5 sm:leading-6" v-if="day.text">
            <div class="float-left mr-1 font-semibold" v-if="day.theday">
                День, когда
            </div>
            <div v-html="day.text"></div>
        </div>
    </li>
</template>
<script setup>
    import marksBlock from './DashboardDayMarks.vue';
    import axios from 'axios';
    import { ref, nextTick } from 'vue';

    const props = defineProps(['dayIndex', 'day']);
    const emits = defineEmits(['selectThisDay', 'noteDataUpdate', 'updateDays']);
    const noteInput = ref(null);
    
    function updateBookmated(){
        const newBookmated = 1 - props.day.bookmated;
        const newNoteData = {...props.day, ...{ bookmated: newBookmated }};

        emits('noteDataUpdate', newNoteData);
        emits('updateDays');

        axios.post('/notes/updateBookmated', {
            noteId: props.day.noteId,
            bookmated: newBookmated
        });
    }
</script>