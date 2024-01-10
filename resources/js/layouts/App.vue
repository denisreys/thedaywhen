<template>
    <headerBlock/>
    <router-view></router-view>
</template>
<script setup>
    import headerBlock from '../components/Header.vue';
    import { useStore } from 'vuex';
    import { useDark, usePreferredDark} from '@vueuse/core';
    
    const store = useStore();
    const preferredDark = usePreferredDark();

    let isDark;

    if(preferredDark !== null) isDark = useDark();
</script>