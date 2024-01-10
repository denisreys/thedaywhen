<template>
    <div class="box-content sm:w-[500px] h-6 xs:h-7 mt-4 xs:mt-5 sm:mx-auto w-full bg-white dark:bg-bg--dark bg-opacity-95 sticky bottom-[43px] py-2 flex justify-between z-30">
        <div class="flex items-end">
            <div class="flex">
                <div class="block pl-7">
                    <label class="flex items-center">
                        <input id="hideempty" 
                        @change="$emit('updateFilters', {hideEmpty: $event.target.checked, 
                                                         bookmated: props.filters.bookmated, 
                                                         date: props.filters.date})" 
                        :checked="props.filters.hideEmpty" 
                        class="w-5 h-5 xs:w-6 xs:h-6  -ml-7 rounded checked:!bg-main after:duration-250 after:ease-soft-in-out duration-250 relative float-left cursor-pointer appearance-none border border-solid dark:bg-block-bg--dark dark:border-none align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white dark:after:text-text--dark after:opacity-0 after:transition-all after:content-['\2713'] after:text-xs sm:after:text-sm checked:border-0 checked:border-transparent checked:after:opacity-100" 
                        type="checkbox" />
                        <label for="hideempty" class="cursor-pointer select-none text-xs ml-1 xs:text-sm xs:ml-2">Заполненное</label>
                    </label>
                </div>
            </div>
            <div class="flex ml-2 xs:ml-3">
                <div class="block pl-7">
                    <label class="flex items-center">
                        <input id="bookmated" 
                        @change="$emit('updateFilters', {hideEmpty: props.filters.hideEmpty, 
                                                         bookmated: $event.target.checked, 
                                                         date: props.filters.date})" 
                        :checked="props.filters.bookmated" 
                        class="w-5 h-5 xs:w-6 xs:h-6  -ml-7 rounded checked:!bg-main after:duration-250 after:ease-soft-in-out duration-250 relative float-left cursor-pointer appearance-none border border-solid dark:bg-block-bg--dark dark:border-none align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white dark:after:text-text--dark after:opacity-0 after:transition-all after:content-['\2713'] after:text-xs sm:after:text-sm checked:border-0 checked:border-transparent checked:after:opacity-100" 
                        type="checkbox"/>
                        <label for="bookmated" class="cursor-pointer select-none text-xs ml-1 xs:text-sm xs:ml-2">Избранное</label>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex -mr-2" v-if="filterDateTitle" >
            <div>
                <button @click="changeMonth('last')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 xs:w-8 xs:h-8 lg:w-7 lg:h-7">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="text-sm px-1 align-bottom h-full leading-6 xs:leading-8 lg:leading-7">{{ filterDateTitle }}</div>
            <div class="">
                <button @click="changeMonth('next')" :class="{'cursor-default opacity-40': nowIsThisMonth}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 xs:w-8 xs:h-8 lg:w-7 lg:h-7">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { computed } from 'vue';
    import { format, addMonths, subMonths, lastDayOfMonth, startOfMonth, getDaysInMonth, isThisMonth } from 'date-fns';
    
    const emit = defineEmits(['updateFilters']);
    let props = defineProps(['filters']);

    let nowIsThisMonth = computed(()=> isThisMonth(props.filters.date.start));
    let filterDateTitle = computed(() => {
        return format(props.filters.date.start, 'MM/yyyy');
    })

    function changeMonth(action){
        let newFilters = {
            hideEmpty: props.filters.hideEmpty, 
            bookmated: props.filters.bookmated,
            date: {
                useDateFilter: props.filters.date.useDateFilter,
                start: props.filters.date.start,
                end: props.filters.date.end,
            },
            skipDays: 0
        };

        if(action == 'next'){
            if(nowIsThisMonth.value) return;

            newFilters.date.start = lastDayOfMonth(addMonths(newFilters.date.start, 1));
        }
        else if(action == 'last'){
            newFilters.date.start = lastDayOfMonth(subMonths(newFilters.date.start, 1));
        }

        if(isThisMonth(newFilters.date.start)){
            newFilters.date.start = new Date();
            newFilters.date.end = subMonths(newFilters.date.start, 1);
        }else {
            newFilters.date.end = startOfMonth(newFilters.date.start);
        }
        newFilters.takeDays = getDaysInMonth(newFilters.date.start);

        emit('updateFilters', newFilters);
    }
</script>