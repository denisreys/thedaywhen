<template>
    <div class="h-12 w-full fixed bottom-0 left-0 bg-white dark:bg-block-bg--dark border-t border-block-border dark:border-block-border--dark shadow-menu z-30">
        <div class="adaptive-section sm:px-0 flex h-full justify-between">
            <button @click="showMenu = true" class="my-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 xs:w-9 xs:h-9">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>
    <component 
        :is="Menu"
        :showMenu="showMenu"
        @hideMenu="showMenu = false">
    </component>
</template>
<script setup>
    import { ref } from 'vue';

    import Menu from './Menu.vue';

    let showMenu = ref(false);
</script>
