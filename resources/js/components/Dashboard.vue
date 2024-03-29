<template>
    <div class="adaptive-section mt-4 mb-12 flex-1 flex flex-col items-stretch relative">
        <div class="flex flex-col justify-end relative flex-1">
            <div v-if="store.state.loaders.content" class="days__overlay">
                <div class="flex m-auto">
                    <svg class="w-6 h-6 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
            </div>
            <TransitionGroup name="list" tag="ul">
                <dayComponent 
                    v-for="(day, dayIndex) in days" 
                    :key="day.fulldate" 
                    :dayIndex="dayIndex" 
                    :day="day" 
                    @selectThisDay="(newSelectedDay) => selectedDay = newSelectedDay"
                    @noteDataUpdate="(newNoteData) => store.commit('setNote', newNoteData)"
                    @updateDays="getDays()"
                />
            </TransitionGroup>
            <div class="flex m-auto" v-show="!days.length">
                <template v-if="filters.bookmated">В этом месяце в избранном пока ничего нет</template>
                <template v-else-if="filters.hideEmpty">В этом месяце вы пока ничего не писали</template>
            </div>
        </div>
        <component
            :is="daysFiltersComponent"
            :filters="filters"
            @updateFilters="updateFilters">
        </component>
    </div>
    <writingPanelComponent
        v-if="selectedDay"
        :selectedDay="days[selectedDay]"
        @noteDataUpdate="(newNoteData) => store.commit('setNote', newNoteData)"
        @updateDays="getDays()"
        @unSelect="selectedDay = null"
    />
    <Footer/>
</template>
<script setup>
    import Footer from './Footer.vue';
    import dayComponent from './DashboardDay.vue';
    import writingPanelComponent from './DashboardWritingPanel.vue';
    import daysFiltersComponent from './DashboardDaysFilters.vue';
    import { format, parse, addDays, subDays, getDaysInMonth, isWeekend } from 'date-fns';
    import { ru } from 'date-fns/locale';
    import { ref, onMounted, nextTick } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();
    const selectedDay = ref(null);
    const days = ref([]);

    const filters = ref({
        hideEmpty: 0,
        bookmated: 0,
        date: {
            start: new Date(),
            end: Date
        },
        takeDays: 0,
    });
    filters.value.takeDays = getDaysInMonth(filters.value.date.start);
    filters.value.date.end = subDays(filters.value.date.start, filters.value.takeDays - 1);
    
    onMounted(() =>{
        setFiltersFromCookie();

        store.dispatch('loadNotes').then(r => {
            getDays();
            
            nextTick(() => {
                scrollToToday();
                selectToday();
            }) 
        });
    });
    
    //METHODS
    function setFiltersFromCookie(){
        const cookieFilter = JSON.parse(localStorage.getItem('filters'));

        if(cookieFilter){
            filters.value.hideEmpty = cookieFilter.hideEmpty;
            filters.value.bookmated = cookieFilter.bookmated;
        }
    }
    function getDays(){
        store.state.loaders.content = true;
        
        let filteredNotes = store.getters.getNotesByFilters(filters.value);
        let newDaysList = []; 

        if(filters.value.bookmated || filters.value.hideEmpty){
            newDaysList = getDaysByFilteredNotes(filteredNotes);
        }else newDaysList = getDaysByDate(filteredNotes);

        if(newDaysList.length){
            const lastDayKey = newDaysList.length - 1;

            if(newDaysList[lastDayKey].fulldate == format(new Date(), 'yyyy-MM-dd')){
                newDaysList[lastDayKey].states.today = true;
            }
        }

        days.value = newDaysList;
        
        store.state.loaders.content = false;
    }
    function getDaysByDate(filteredNotes){
        let days = []; let day;

        for(let i = 0; i < filters.value.takeDays; i++){
            if(i == 0) day = filters.value.date.end;
            else day = addDays(day, 1);

            days[i] = getDayInfo(day, addNoteToDay());

            function addNoteToDay(){
                let noteByThisDay = filteredNotes.filter((note, index) => {
                    if(note.fulldate == format(day, 'yyyy-MM-dd')){
                        return note;
                    }
                });
                
                if(noteByThisDay[0]) return noteByThisDay[0];
                else return false;
            }
        }

        return days;
    }
    function getDaysByFilteredNotes(filteredNotes){
        let days = []; let day;
        filteredNotes.forEach((note, index) => {
            day = parse(note.fulldate, 'yyyy-MM-dd', new Date());
            
            days[index] = getDayInfo(day, note);
        });
        if(days.length && !filters.value.bookmated){
            const lastDay = days[days.length - 1];
            const today = format(new Date(), 'yyyy-MM-dd');
            const filterStartRightFormat = format(filters.value.date.start, 'yyyy-MM-dd');

            if(filterStartRightFormat == today && lastDay.fulldate != today){
                days.push(getDayInfo(new Date()));
            }
        }
        return days;
    }
    function getDayInfo(date, note){
        const monthAndDay = format(date, 'MM-dd');
        if(!note) note = { id: null, text: '', theday: 1, bookmated: 0 };

        return {
            fulldate: format(date, 'yyyy-MM-dd'),
            day: format(date, 'dd'),
            month: format(date, 'MMMM', { locale: ru }),
            dayWeek: format(date, 'EEEEEE', { locale: ru }),
            text: note.text,
            theday: note.theday,
            bookmated: note.bookmated,
            noteId: note.id,
            states: {
                 today: false, 
                 weekend: isWeekend(date),
                 newYear: monthAndDay == '12-31',
                 christmas: monthAndDay == '12-25' || monthAndDay == '01-07',
                 firstDayOfWinter: monthAndDay == '12-01',
                 firstDayOfSpring: monthAndDay == '03-01',
                 firstDayOfSummer: monthAndDay == '06-01',
                 firstDayOfAutumn: monthAndDay == '09-01',
            }
        };
    }
    function scrollToToday(){
        nextTick(() => window.scrollTo(0, document.body.scrollHeight));
    }
    function selectToday(){
        const lastDayKey = days.value.length - 1;
        const lastDay = days.value[lastDayKey];

        if(!lastDay.text) selectedDay.value = lastDayKey;
    }
    function updateFilters(newFilters){
        filters.value = {...filters.value, ...newFilters};
        
        getDays();
        scrollToToday();
        localStorage.setItem('filters', JSON.stringify(filters.value));
    }
</script>
<style scoped>
    .list-enter-active {
        transition: all 0.3s ease;
    }
    .list-enter-from {
        opacity: 0;
    }
</style>