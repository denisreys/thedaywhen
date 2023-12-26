<template>
    <header class="w-full pt-2 pb-[2px] fixed left-0 top-0 z-30 bg-main bg-opacity-95 before:content-[''] before:absolute before:-bottom-[5px] before:left-0 before:border-solid before:border-b-0 before:border-t-[6px] before:border-x-[50vw] before:border-y-main before:border-x-transparent before:opacity-95">
        <img class="h-[18px] xs:h-5 m-auto" src="/images/logo-w.png" alt="thedaywhen">
        <div class="absolute h-3 w-full bg"></div>
    </header>
    <router-view></router-view>
</template>
<script setup>
    import { useStore } from 'vuex';
    import { useDark, usePreferredDark} from '@vueuse/core';
    
    const store = useStore();
    const preferredDark = usePreferredDark();

    let isDark;
    
    if(preferredDark !== null) isDark = useDark();
</script>