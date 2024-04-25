<template>
    <ul class="flex absolute left-0">
        <li v-for="mark in thisDayMarks" title="Рождество!" class="mr-1 fill-text dark:fill-text--dark">
            <component :is="mark.icon"></component>
        </li>
    </ul>
</template>
<script setup>
    import iconChristmas from '../icons/IconChristmasTree.vue';
    import iconFireworks from '../icons/IconFireworks.vue';
    import iconSnowflake from '../icons/IconSnowflake.vue';
    import iconSpring from '../icons/IconSpring.vue';
    import iconAutumn from '../icons/IconAutumn.vue';
    import iconSun from '../icons/IconSun.vue';

    import { computed } from 'vue';

    const props = defineProps(['marks']);

    const marksList = [
        {title: 'Рождество', isToday: props.marks.christmas, icon: iconChristmas},
        {title: 'Новый год', isToday: props.marks.newYear, icon: iconFireworks},
        {title: 'Международый женский день', isToday: props.marks.womensDay, icon: iconFireworks},
        {title: 'Первый день зимы', isToday: props.marks.firstDayOfWinter, icon: iconSnowflake},
        {title: 'Первый день весны', isToday: props.marks.firstDayOfSpring, icon: iconSpring},
        {title: 'Первый день лета', isToday: props.marks.firstDayOfSummer, icon: iconSun},
        {title: 'Первый день осени', isToday: props.marks.firstDayOfAutumn, icon: iconAutumn},
    ];
    const thisDayMarks = computed(() => {
        return marksList.filter((mark) => mark.isToday);
    });
</script>