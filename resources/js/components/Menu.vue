<template>
    <div :class="!showMenu ? 'hideMenu' : ''" class="fixed left-0 top-0 w-full h-full z-50">
        <div class="overlay w-full h-full bg-black bg-opacity-40 cursor-pointer backdrop-blur-sm" @click="$emit('hideMenu')">
            <div class="bg-white dark:bg-bg--dark flex flex-col h-full w-[90%] xs:w-[85%] max-w-sm cursor-default slide relative" @click.stop>
                <div class="px-3 xs:px-4 py-5 xs:py-6 flex-1 flex justify-between bg-main dark:bg-[#8c819c]">
                    <div class="my-auto">
                        <img class="h-5 xs:h-6 my-auto dark:opacity-90" src="/images/logo-w.png" alt="thedaywhen">
                    </div>
                    <div class="h-6">
                        <button @click="toggleDark()">
                            <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white dark:text-text--dark w-6 h-6">
                            <path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white dark:text-text--dark w-6 h-6">
                            <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="py-7 xs:py-8 px-3 xs:px-4 flex flex-col items-stretch h-full overflow-y-auto" v-if="showMenu">
                    <div class="flex-1 flex flex-col justify-end">
                        <KeepAlive>
                            <achievementsBlock v-if="selectedTab == 0"/>
                            <updatesBlock v-else-if="selectedTab == 1"/>
                            <helpBlock v-else-if="selectedTab == 2"/>
                            <settingsBlock v-else-if="selectedTab == 3"/>
                        </KeepAlive>
                    </div>
                </div>
                <ul class="flex px-1 xs:px-2 py-1 bg-block-bg dark:bg-block-bg--dark border-t border-block-border dark:border-block-border--dark shadow-menu">
                    <li v-for="(tab, tabIndex) in tabs" class="text-xs text-small-text flex-1 text-center rounded" :class="{'!bg-main dark:!bg-bg--dark !text-white dark:!text-text--dark;': tabIndex == selectedTab}">
                        <a class="block cursor-pointer py-1" @click="selectedTab = tabIndex">
                            <component class="m-auto !w-5 !h-5" :is="tab.icon"></component>
                            <span class="hidden xs:block">{{ tab.name }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script setup>
    import iconTrophy from '../icons/IconTrophy.vue';
    import iconCog from '../icons/IconCog.vue';
    import iconQuestion from '../icons/IconQuestion.vue';
    import iconUpdates from '../icons/IconUpdates.vue';
    import achievementsBlock from './MenuAchievements.vue';
    import settingsBlock from './MenuSettings.vue';
    import updatesBlock from './MenuUpdates.vue';
    import helpBlock from './MenuHelp.vue';
    import { ref } from 'vue';
    import { useDark, useToggle } from '@vueuse/core';

    defineProps(['showMenu']);

    let selectedTab = ref(0);
    let tabs = [
        { name: 'Достижения', icon: iconTrophy},
        { name: 'Обновления', icon: iconUpdates },
        { name: 'Помощь', icon: iconQuestion },
        { name: 'Настройки', icon: iconCog },
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