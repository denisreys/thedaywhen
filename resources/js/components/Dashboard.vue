<template>
    <div class="px-4 mt-4 mb-10 flex-1 sm:w-[500px] sm:mx-auto flex flex-col items-stretch">
        <div class="flex-1">
            <ul class="">
                <li class="bg-mylightgray rounded p-3 xs:px-4 mb-5 last:mb-0 cursor-pointer hover:bg-opacity-60 active:opacity-50" v-for="day in days">
                    <div class="relative">
                        <div class="day__title">{{ day.day }}</div>
                        <button class="absolute right-0 top-0" v-if="day.text">
                            <template v-if="day.boockmated">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 fill-main">
                                <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd" />
                                </svg>
                            </template>
                            <template v-else>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-slate-300 hover:stroke-slate-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                </svg>
                            </template>
                        </button>
                    </div>
                    <div class="mt-4" v-if="day.text">
                        <div v-if="day.theday" class="float-left bg-main text-white px-1 rounded mr-2 align-middle">
                            <span class="my-auto mr-1">The day</span>
                        </div>
                        <div class="">{{ day.text }}</div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="w-full bg-white sticky left-0 bottom-10 py-1 mt-4 flex justify-between">
            <div class="flex items-end">
                <div class="flex items-center me-2 xs:me-3">
                    <div class="block min-h-6 pl-7">
                        <label>
                            <input id="checkbox-1" class="w-4 h-4 -ml-6 rounded checked:bg-main after:duration-250 after:ease-soft-in-out duration-250 relative float-left cursor-pointer appearance-none border border-solid align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\2713'] after:text-xs checked:border-0 checked:border-transparent checked:after:opacity-100" type="checkbox" />
                            <label for="checkbox-1" class="cursor-pointer select-none text-xs align-top">Hide empty</label>
                        </label>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="block min-h-6 pl-7">
                        <label>
                            <input id="checkbox-1" class="w-[18px] h-[18px] -ml-6 rounded checked:bg-main after:duration-250 after:ease-soft-in-out duration-250 relative float-left cursor-pointer appearance-none border border-solid align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\2713'] after:text-xs checked:border-0 checked:border-transparent checked:after:opacity-100" type="checkbox" />
                            <label for="checkbox-1" class="cursor-pointer select-none text-xs align-top">Bookmated</label>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex -mr-2 items-center">
                <div class="mt-1">
                    <button class="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <span class="px-[5px] text-sm">11/2023</span>
                <div class="mt-1">
                    <button class="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <editBlock />
    </div>
    <Footer />
</template>
<script setup>
    import Footer from './Footer.vue';
    import editBlock from './EditBlock.vue';
    import { ref, reactive } from 'vue';
    import { onMounted } from 'vue';

    onMounted(() => {
        window.scrollTo(0, document.body.scrollHeight);;
    })

    let days = [
        {day: '25 november', text: 'lorem ipsum dolor sit amet.', theday: true, boockmated: false},
        {day: '26 november', text: 'ipsum dolor sit .', theday: false, boockmated: false},
        {day: '27 november', text: 'adipisicing elit. Voluptatum, magni? .', theday: false, boockmated: false},
        {day: '28 november', text: 'dolor,  elit. Voluptatum, magni?', theday: true, boockmated: true},
        {day: '29 november', text: 'sit amet consectetur adipisicing elit. Voluptatum, magni?', theday: true, boockmated: false},
        {day: '30 november', text: 'sit amet consectetur adipisicing elit. Voluptatum, magni?', theday: false, boockmated: false},
        {day: 'Today', text: '', theday: false, boockmated: false},
    ]

    let test = '';
    
</script>