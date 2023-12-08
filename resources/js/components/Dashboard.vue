<template>
    <div class="adaptive-section mt-4 mb-10 flex-1 flex flex-col items-stretch relative">
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