<template>
    <div class="flex flex-col justify-end relative flex-1">
        <div v-if="loaders.daysCenter" class="fixed top-0 left-0 flex z-20 h-full w-full bg-white bg-opacity-50 backdrop-blur-sm">
            <div class="flex m-auto">
                <svg class="w-6 h-6 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
        </div>
        <div class="m-auto mb-5 h-6" v-if="days.length">
            <button @click="getDays('more')" v-if="!loaders.daysTop" class="text-sm">show more</button>
            <svg v-else class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
        </div> 
        <ul ref="focusTo" v-if="days.length">
            <li class="bg-mylightgray rounded p-3 xs:p-4 mb-3 sm:mb-4 cursor-pointer border border-[#f4f4f4]" 
            :class="{
                'day--notactive': selectDay != null && dayIndex != selectDay, 
                'day--active': dayIndex == selectDay
            }" 
            v-for="(day, dayIndex) in days" 
            :key="dayIndex" 
            @click="changeSelectedDay(dayIndex)">
                <div class="relative flex">
                    <div class="flex mx-auto">
                        <div class="text-2xl font-bold">{{ day.day }}</div>
                        <div class="ml-2 flex flex-col justify-around">
                            <div class="text-xs uppercase -mb-2">{{ day.dayWeek }}</div>
                            <div class="text-xs lowercase text-gray-400">{{ day.month }}</div>
                        </div>
                    </div>
                    <div class="absolute right-0 top-0" v-if="selectDay == dayIndex && loaders.note">
                        <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                    <button class="absolute right-0 top-0" v-else-if="day.text" @click.stop="day.bookmated = 1 - day.bookmated;save(null, dayIndex)">
                        <template v-if="day.bookmated">
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
                <div class="mt-4 overflow-hidden" v-if="day.text || selectDay == dayIndex">
                    <div class="float-left bg-main text-white px-[2px] rounded mr-2 align-middle cursor-pointer">
                        <button class="flex" @click.stop="day.theday = 1 - day.theday;save(null, dayIndex)">
                            <template v-if="day.theday">
                                <span class="my-auto mx-1">The day</span>
                                <span class="my-auto" v-if="selectDay == dayIndex">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </span>
                            </template>
                            <template v-else-if="!day.theday && selectDay == dayIndex">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                            </template>
                        </button>
                    </div>
                    <div 
                        autocapitalize="none"
                        spellcheck="false"
                        @keydown.enter="changeSelectedDay(dayIndex)"
                        @click.stop="selectDay = dayIndex"
                        @focusout="textUpdate(dayIndex)"
                        contenteditable="true"
                        @input="event => save(event, dayIndex)"
                        v-html="dayText(dayIndex)"
                    ></div>
                </div>
            </li>
        </ul>
        <div class="flex m-auto" v-else>
            <template v-if="filters.bookmated">there is nothing in bookmarks yet</template>
            <template v-else-if="filters.hideEmpty">there are no entries yet</template>
        </div>
    </div>
    <daysFilters 
        :filters="filters"
        @updateFilters="updateFilters"
    />
</template>
<script setup>
    import axios from 'axios';
    import daysFilters from './DashboardDaysFilters.vue'
    import { ref, onMounted, nextTick, watch} from 'vue';

    let timer;
    const loaders = ref({
        daysCenter: false,
        daysTop: false,
        note: false
    });
    const selectDay = ref(null);
    const focusTo = ref(null);
    const days = ref([]);
    const filters = ref({
        hideEmpty: false,
        bookmated: false,
        date: {
            title: false,
            moved: 0
        }
    });
    let daysOffset = 0;

    onMounted(() => {
        getDays('mounted');
    });

    function updateFilters(newFilters){
        daysOffset = 0;
        filters.value = newFilters;
        getDays('filtered');
    }
    function dayText(dayIndex){
        let html = '';
        
        for(let text of days.value[dayIndex].text){
            html += text;
        }
        return html+'<br/>';
    }
    function getDays(action){
        if(action == 'filtered' || action == 'mounted') loaders.value.daysCenter = true;
        else if(action == 'more') loaders.value.daysTop = true;
        
        axios.post('/notes', {
            bookmated: filters.value.bookmated,
            hideEmpty: filters.value.hideEmpty,
            filterDate: filters.value.date.moved,
            daysOffset: daysOffset
        })
        .then(response => { 
            if(days.value.length && daysOffset){
                days.value = [...response.data.days, ...days.value];
            }else {
                days.value = response.data.days;
            }
            if(days.value.length) {
                filters.value.date.title = days.value[days.value.length - 1].fulldate;
            }else {
                filters.value.date.title = false;
            }
            
            let oldScrollPosition = document.body.scrollHeight;
            nextTick(() => {
                if(daysOffset != 0){
                    window.scrollTo(0, document.body.scrollHeight - oldScrollPosition);
                }else {
                    window.scrollTo(0, document.body.scrollHeight);
                }
                daysOffset = response.data.daysOffset;
            });
        })
        .finally(() => {
            loaders.value.daysCenter = loaders.value.daysTop = false;
        });
    }
    function changeSelectedDay(dayIndex){
        if(selectDay.value == dayIndex){
            focusTo.value.children[selectDay.value].lastChild.lastChild.blur();
            selectDay.value = null;
        }else {
            selectDay.value = dayIndex;

            nextTick(() => {
                focusTo.value.children[dayIndex].lastChild.lastChild.focus();
            });
        }
    }
    function textUpdate(dayIndex){
        if(days.value[dayIndex].newText === undefined){
            return;
        }
        else if(days.value[dayIndex].newText || days.value[dayIndex].newText.length == 0){
            days.value[dayIndex].text = days.value[dayIndex].newText;
        }
    }
    function save(e, dayIndex){
        
        if(timer) clearTimeout(timer);
        let delayTime = 1200;
        selectDay.value = dayIndex;
        let data = days.value[selectDay.value];
        let text;

        if(e !== null){
            days.value[dayIndex].newText = text = e.target.innerText.trim();
        }else {
            delayTime = 0;
            text = days.value[dayIndex].text;
        }

        timer = setTimeout(() => {
            loaders.value.note = true;
            axios.post('/notes/createorupdate', {
                text: text,
                fulldate: data.fulldate,
                bookmated: data.bookmated,
                theday: data.theday
            })
            .finally(() => {
                loaders.value.note = false;
            });
        }, delayTime);    
    }
</script>