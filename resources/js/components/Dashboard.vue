<template>
    <div class="px-4 mt-4 mb-10 flex-1 sm:w-[500px] sm:mx-auto flex flex-col items-stretch relative">
        <daysBlock/>
    </div>
    <Footer />
</template>
<script setup>
    import Footer from './Footer.vue';
    import daysBlock from './DashboardDays.vue';
    import { ref } from 'vue';
    import { onMounted, onUpdated } from 'vue';
</script>