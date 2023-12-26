<template>
    <div class="h-11 w-full fixed bottom-0 left-0 bg-white dark:bg-bg--dark shadow-menu z-30">
        <div class="sm:w-[500px] sm:mx-auto py-[8px] px-3 xs:px-4 sm:px-0 flex justify-between items-center">
            <div class="">
                <button @click="showMenu = true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 xs:w-8 xs:h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <!-- <div>
                <button @click="$router.go()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </button>
            </div> -->
        </div>
    </div>
    <Menu 
        :showMenu="showMenu"
        @hideMenu="showMenu = false"
    />
</template>
<script setup>
    import { ref } from 'vue';

    import Menu from './Menu.vue';

    let showMenu = ref(false);
</script>
