<template>
    <div class="w-full bg-white sticky left-0 bottom-10 py-1 flex justify-between z-30">
        <div class="flex items-end">
            <div class="flex items-center me-2 xs:me-3">
                <div class="block min-h-6 pl-7">
                    <label>
                        <input id="hideempty" @change="$emit('updateFilters', {hideEmpty: $event.target.checked, bookmated: props.filters.bookmated, date: props.filters.date})" :checked="props.filters.hideEmpty" class="w-4 h-4 -ml-6 rounded checked:bg-main after:duration-250 after:ease-soft-in-out duration-250 relative float-left cursor-pointer appearance-none border border-solid align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\2713'] after:text-xs checked:border-0 checked:border-transparent checked:after:opacity-100" type="checkbox" />
                        <label for="hideempty" class="cursor-pointer select-none text-xs align-top">Hide empty</label>
                    </label>
                </div>
            </div>
            <div class="flex items-center">
                <div class="block min-h-6 pl-7">
                    <label>
                        <input id="bookmated" @change="$emit('updateFilters', {hideEmpty: props.filters.hideEmpty, bookmated: $event.target.checked, date: props.filters.date})"  class="w-4 h-4 -ml-6 rounded checked:bg-main after:duration-250 after:ease-soft-in-out duration-250 relative float-left cursor-pointer appearance-none border border-solid align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\2713'] after:text-xs checked:border-0 checked:border-transparent checked:after:opacity-100" type="checkbox" />
                        <label for="bookmated" class="cursor-pointer select-none text-xs align-top">Bookmated</label>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex -mr-2 items-center" v-if="filterDateTitle" :class="{'opacity-25 !cursor-default': props.filters.hideEmpty || props.filters.bookmated}">
            <div class="mt-1">
                <button @click="changeMonth('last')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <span class="px-[5px] text-sm">{{ filterDateTitle }}</span>
            <div class="mt-1">
                <button @click="changeMonth('next')" :class="{'cursor-default opacity-40': props.filters.date.moved == 0}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { computed } from 'vue';

    const emit = defineEmits(['updateFilters']);
    let props = defineProps(['filters']);

    let filterDateTitle;
    
    filterDateTitle = computed(() => {
        if(props.filters.date.title){
            const dateSepareted = props.filters.date.title.split('-');
            if(dateSepareted[1][0] == '0') dateSepareted[1] = dateSepareted[1][1];
            return dateSepareted[1]+'/'+dateSepareted[0];
        }else {
            return false;
        }
    });
    
    function changeMonth(action){
        if(props.filters.date.moved == 0 && action == 'next') return;
        
        let dateSepareted = props.filters.date.title.split('-');
        let newMoved = props.filters.date.moved;

        if(action == 'next'){
            newMoved++;
            dateSepareted[1]++;
            if(dateSepareted[1] > 12){
                dateSepareted[1] = 1;
                dateSepareted[0]++;
            }
        }
        else if(action == 'last'){
            newMoved--;
            dateSepareted[1]--;
            if(dateSepareted[1] < 1){
                dateSepareted[1] = 12;
                dateSepareted[0]--;
            }
        }
        dateSepareted[2] = 1;
        const newDate = dateSepareted[0]+'-'+dateSepareted[1]+'-'+dateSepareted[2];

        emit('updateFilters', {
            hideEmpty: props.filters.hideEmpty, 
            bookmated: props.filters.bookmated, 
            date: {
                title: newDate,
                moved: newMoved
            }
        });
    }
</script>