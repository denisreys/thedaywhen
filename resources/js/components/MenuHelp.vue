<template>
    <ul class="mb-8">
        <li class="mb-2 last:mb-0" v-for="itemfather in nav">
            <a class="font-semibold before:content-['#'] before:text-main before:mr-1 before:text-lg before:leading-none" :href="'#'+itemfather.ancor">
                {{ itemfather.name }}
            </a>
            <ul class="mt-2 ml-5" v-if="itemfather.list">
                <li class="mb-1 last:mb-0" v-for="itemchild in itemfather.list">
                    <a class="before:content-['#'] before:text-main before:mr-1 before:text-lg before:leading-none" :href="'#'+itemchild.ancor">
                        {{ itemchild.name }}
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="mb-8" id="almostapp">
        <h2 class="text-xl font-semibold mb-4">Почти приложение</h2>
        <div class="leading-5 sm:leading-6 mb-4">
            Добавьте thedaywhen на главный экран своего телефона. Это не только ускорит доступ к сайту, но также скроет адресную строку браузера, делая пользовательский опыт более удобным, похожим на приложение.
        </div>
        <div class="flex">
            <div class="flex-1 mr-1">
                <img src="/images/help/toapp1.jpeg" alt="toapp1">
            </div>
            <div class="flex-1">
                <img src="/images/help/toapp2.jpeg" alt="toapp2">
            </div>
        </div>
    </div>
    <div id="feedback">
        <h2 class="text-xl font-semibold mb-4">Связь</h2>
        <div class="leading-5 sm:leading-6 mb-4">
            <a href="https://t.me/denis_reys" class="link" target="_blank">@denis_reys</a>
        </div>
    </div>
</template>
<script setup>
    const nav = [
        {
            name: 'Рекомендации',
            ancor: 'recommendations',
            list: [
                {
                    name: 'Почти приложение',
                    ancor: 'almostapp'
                },
            ]
        },
        {
            name: 'Связь',
            ancor: 'feedback',
        },
    ]
</script>