<template>
    <div class="mb-5">
        <div class="text-small-text dark:text-small-text--dark">В разработке:</div>
        <ul class="list-disc pt-3 pl-5" v-if="inProcessUpdates.length">
            <li class="mb-1" v-for="update in inProcessUpdates">
                <div class="font-semibold">{{ update.name }}</div>
                <div class="text-sm">{{ update.desc }}</div>
            </li>
        </ul>
    </div>
    <div class="mb-5">
        <div class="text-small-text dark:text-small-text--dark">В планах:</div>
        <ul class="list-disc pt-3 pl-5" v-if="futureUpdates.length">
            <li class="mb-1" v-for="update in futureUpdates">
                <div class="font-semibold">{{ update.name }}</div>
                <div class="text-sm">{{ update.desc }}</div>
            </li>
        </ul>
    </div>
    <div class="">
        <div class="text-small-text dark:text-small-text--dark">Завершенное:</div>
        <ul class="list-disc pt-3 pl-5" v-if="finishedUpdates.length">
            <li class="mb-1" v-for="update in finishedUpdates">
                <div class="font-semibold">{{ update.name }}</div>
                <div class="text-sm ">{{ update.desc }}</div>
            </li>
        </ul>
    </div>
</template>
<script setup>
    import { ref, computed } from 'vue';

    /*
        STATES: 
        0 - в планах
        1 - в разработке
        2 - завершено
    */
    const updates = [
        {
            name: 'Раздел обновления',
            desc: 'Раздел обновления веб-приложения для информирования о планах',
            state: 2
        },
        {
            name: 'Раздел помощь',
            desc: 'Раздел с рекомендациями по использованию tdw и для помощи в решении проблем с которыми пользователи могут столкнуться.',
            state: 1
        },
        {
            name: 'Обновление светлой темы',
            desc: 'Более удобная светлая тема',
            state: 0
        },
        {
            name: 'Аутентификация через Telegram',
            desc: 'Аутентификация и привязка Telegram аккаунта',
            state: 0
        },
        {
            name: 'Telegram Web Apps',
            desc: 'Возможность открывать и использовать сайт внутри Telegram',
            state: 0
        },
        {
            name: 'Расширение функционала Telegram бота',
            desc: 'Уведомления и возможность писать на сайт прямо через бота',
            state: 0
        },
        {
            name: 'Мультиязычность',
            desc: 'Не помешает',
            state: 0
        },
    ];

    const futureUpdates = []; 
    const inProcessUpdates = []; 
    const finishedUpdates = []; 

    updates.forEach((update) => {
        switch(update.state){
            case 0:
                futureUpdates.push(update);
                break;
            case 1:
                inProcessUpdates.push(update);
                break;
            case 2:
                finishedUpdates.push(update);
                break;
        }

    });
</script>