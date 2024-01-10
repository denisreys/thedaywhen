<template>
    <div :class="!showMenu ? 'hideMenu' : ''" class="fixed left-0 top-0 w-full h-full z-50">
        <div class="overlay w-full h-full bg-black bg-opacity-40 cursor-pointer backdrop-blur-sm" @click="$emit('hideMenu')">
            <div class="bg-white dark:bg-bg--dark flex flex-col h-full w-4/5 max-w-sm cursor-default slide" @click.stop>
                <div class="w-full h-1/2 bg-main flex flex-col justify-between relative px-5 pt-5">
                    <div class="flex-1 flex">
                        <div class="my-auto">
                            <img class="h-6 xs:h-8 lg:h-7 my-auto dark:opacity-90" src="/images/logo-w.png" alt="thedaywhen">
                        </div>
                        <button @click="toggleDark()" class="absolute top-3 right-3">
                            <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white w-6 h-6 xs:w-7 xs:h-7">
                            <path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white w-6 h-6 xs:w-7 xs:h-7">
                            <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <ul class="flex">
                        <li v-for="(tab, tabIndex) in tabs" class="mr-3 xs:mr-4 last:mr-0 border-b-4 border-transparent text-text--dark" :class="{'border-white !text-white': tabIndex == selectedTab}">
                            <a class="block pb-2 cursor-pointer " @click="selectedTab = tabIndex">
                                {{ tab.name }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="py-8 px-5 h-full overflow-y-auto" v-if="showMenu">
                    <achievementsBlock v-if="selectedTab == 0"/>
                    <settingsBlock v-else-if="selectedTab == 1"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import achievementsBlock from './MenuAchievements.vue';
    import settingsBlock from './MenuSettings.vue';
    import { ref } from 'vue';
    import { useDark, useToggle } from '@vueuse/core';

    defineProps(['showMenu']);

    let selectedTab = ref(0);
    let tabs = [
        { name: 'Достижения', },
        { name: 'Настройки', },
    ];
    
    const isDark = useDark();
    const toggleDark = useToggle(isDark);
</script>
<style>
    .slide, .overlay {
        transition: 400ms;
    }
    .hideMenu {
        transition-delay: 401ms;
        height: 0;
    }
    .hideMenu .slide {
        transform: translateX(-100vw);
    }
    .hideMenu .overlay {
        opacity: 0;
    }
</style>