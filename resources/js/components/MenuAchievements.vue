<template>
    <div class="mb-5 xs:mb-5 pb-4 border-b border-block-border dark:border-block-bg--dark">
        <ul class="flex justify-between">
            <li class="" v-for="(card, index) in cards" :key="index">
                <div class="flex">
                    <div class="flex mx-auto">
                        <div class="mr-1 my-auto"><component :is="card.icon"></component></div>
                        <div class="text-2xl leading-6 font-semibold">{{ card.value }}</div>
                    </div>
                </div>
                <div class="text-xs mt-1 text-center text-small-text dark:text-small-text--dark">{{ card.label }}</div>
            </li>
        </ul>
    </div>
    <div class="flex flex-col flex-1">
        <ul class="mb-4">
            <li class="mb-5 last:mb-0 overflow-hidden flex" v-for="(achievement, index) in achievements" :key="'c-'+index">
                <div class="mr-2 xs:mr-3">
                    <component :is="achievement.icon"></component>
                </div>
                <ul class="flex-1">
                    <div class="flex justify-between mb-2">
                        <div class="text-base mr-1 font-semibold leading-none">
                            {{ achievement.lastDoneTarget.name }}
                        </div>
                        <div class="flex whitespace-nowrap font-semibold leading-none"
                            :class="[
                                        {'!text-yellow-100': achievement.lastDoneTarget.id == 1},
                                        {'!text-yellow-200': achievement.lastDoneTarget.id == 2},
                                        {'!text-yellow-300': achievement.lastDoneTarget.id == 3},
                                        {'!text-yellow-400': achievement.lastDoneTarget.id >= 4}
                                    ]">
                            {{ `${ achievement.lastDoneTarget.id } ур.` }}
                        </div>
                    </div>
                    <div class="mb-2 leading-none text-sm text-small-text dark:text-small-text--dark">
                        {{ achievement.desc }}
                    </div>
                    <div class="h-4 w-full bg-block-bg dark:bg-block-bg--dark rounded-md relative" :title="achievement.progress+'%'">
                        <span class="whitespace-nowrap absolute w-full left-0 text-center text-xs leading-4">
                            <template v-if="achievement.nextTarget">
                                {{ `${ achievement.current } из ${ achievement.nextTarget.value }` }}
                            </template>
                            <template v-else>
                                {{ `${ achievement.current } из ${ achievement.lastDoneTarget.value }` }}
                            </template>
                        </span>
                        <div class="bg-main dark:bg-main--dark h-full rounded-md" 
                            :style="{ 
                            width: achievement.progress+'%'}">
                        </div>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</template>
<script setup>
    import iconFire from '../icons/IconFire.vue';
    import iconBook from '../icons/IconBook.vue';
    import iconFlag from '../icons/IconFlag.vue';
    import iconHeart from '../icons/IconHeart.vue';
    import { useStore } from 'vuex';
    import { format, parse, addDays, subDays} from 'date-fns';
    import { computed } from 'vue';

    const store = useStore();

    const hotSeries = computed(() => {
        const dividedNotesByHotSeries = divideNotesByHotSeries();

        return {
            best: getBestHotSeries(dividedNotesByHotSeries),
            current: getCurrentHotSeries(dividedNotesByHotSeries)
        }
    });
    const notesCount = computed(() => {
        return store.state.notes.length;
    });
    const longestNoteCount = computed(() => {
        return getLongestNote(store.state.notes);
    });
    const bookmatedNotesCount = computed(() => {
        return store.getters.getBookmatedNotes.length;
    });

    let achievements = [
        new Achievement(
            'Пишите # дней без пропуска.',
            hotSeries.value.best,
            iconFire,
            [
                {
                    value: 0,
                    name: 'Начинающий Записчик'
                },
                {
                    value: 7,
                    name: 'Увлеченный Хроникер'
                },
                {
                    value: 14,
                    name: 'Подающий Надежды Мемуарист'
                },
                {
                    value: 30,
                    name: 'Неутомимый Биограф'
                },
                {
                    value: 100,
                    name: 'Легендарный Летописец'
                },
            ]
        ),
        new Achievement(
            'Опишите день текстом длиной # символов.',
            longestNoteCount.value,
            iconBook,
            [
                {
                    value: 0,
                    name: 'Талант брат краткости'
                },
                {
                    value: 200,
                    name: 'Талантливый Рассказчик'
                },
                {
                    value: 500,
                    name: 'Матерый Повестник'
                },
                {
                    value: 1000,
                    name: 'Знаменитый Романист'
                },
            ]
        ),
        new Achievement(
            'Добавить в избранное # дней.',
            bookmatedNotesCount.value,
            iconHeart,
            [
                {
                    value: 0,
                    name: 'Писатель В Стол'
                },
                {
                    value: 5,
                    name: 'Ноунейм'
                },
                {
                    value: 20,
                    name: 'Андерграунд'
                },
                {
                    value: 50,
                    name: 'Мейнстрим'
                },
                {
                    value: 100,
                    name: 'Легенда'
                },
            ]
        ),
        new Achievement(
            'Напишите в совокупности # записей.',
            notesCount.value,
            iconFlag,
            [
                {
                    value: 0,
                    name: 'Познающий Азы'
                },
                {
                    value: 50,
                    name: 'Любознательный писатель'
                },
                {
                    value: 100,
                    name: 'Алхимик Слов'
                },
                {
                    value: 150,
                    name: 'Мастер Блокнота'
                },
                {
                    value: 300,
                    name: 'Император Письма'
                },
                {
                    value: 500,
                    name: 'Всевластный Словесник'
                },
            ]
        ),
    ]; 

    const cards = [
        {
            value: hotSeries.value.current,
            label: 'Сейчас',
            icon: iconFire
        },
        {
            value: hotSeries.value.best,
            label: 'Рекорд',
            icon: iconFire
        },
        {
            value: bookmatedNotesCount,
            label: 'Избранное',
            icon: iconHeart
        },
        {
            value: notesCount,
            label: 'Всего',
            icon: iconFlag
        },
    ];

    //METHODS
    function Card(label, value, icon) {
        this.label = label;
        this.value = value;
        
        this.icon = icon;
    }
    function Achievement(desc, current, icon, targets) {
        this.desc = desc;
        this.current = current;
        this.icon = icon;
        this.targets = targets;

        this.getLastDoneTarget = function(){
            let lastDoneTarget;

            for(let i = 0; i < this.targets.length; i++){
                if(this.targets[i].value <= this.current) {
                    lastDoneTarget = { ...{ id: i }, ...this.targets[i] };
                }else break;
            }

            return lastDoneTarget;
        }
        this.getNextTarget = function(){
            const nextTargetIndex = this.lastDoneTarget.id + 1;

            if(this.targets[nextTargetIndex]){
                return { ...{ id: nextTargetIndex }, ...this.targets[nextTargetIndex] };
            }

            return false;
        }
        this.calculateProgress = function(){
            if(this.nextTarget){
                const residueTarget = this.nextTarget.value - this.lastDoneTarget.value;
                const residueCurrent = this.current - this.lastDoneTarget.value;
                const progressInPercentage = Number(((residueCurrent / residueTarget) * 100).toFixed(2))
                
                return progressInPercentage;
            }
            
            return 100;
        };
        this.addTargetToDesc = function(){
            let targetValue;

            if(this.nextTarget) targetValue = this.nextTarget.value;
            else targetValue = this.lastDoneTarget.value;

            return this.desc.replace(/\#/, targetValue);
        }

        this.lastDoneTarget = this.getLastDoneTarget();
        this.nextTarget = this.getNextTarget();
        this.progress = this.calculateProgress();
        this.desc = this.addTargetToDesc();
    }
    function getLongestNote(notes){
        let longestNote;

        if(notes.length) longestNote = notes[0].text.length;
        else return 0;

        for(let i = 1; i < notes.length; i++){
            const note = notes[i];
            const textLength = note.text.length;
            if(longestNote < textLength) longestNote = textLength;
        }

        return longestNote;
    }
    function divideNotesByHotSeries(){
        let parts = [];
        let thisPart = [];

        store.getters.getNotes.forEach(note => {
            if(thisPart.length) {
                const lastNoteInThisPart = thisPart[thisPart.length - 1];
                const lastNoteDate = parse(lastNoteInThisPart.fulldate, 'yyyy-MM-dd', new Date());
                const nextDayOfTheSeries = format(addDays(lastNoteDate, 1), 'yyyy-MM-dd');

                if(note.fulldate == nextDayOfTheSeries){
                    thisPart.push(note);
                }else {
                    parts.push(thisPart);
                    thisPart = [note];
                }
            }else {
                thisPart.push(note);
            }
        });

        parts.push(thisPart)

        return parts;
    }
    function getBestHotSeries(hotSeries){
        let bestHotSeries = hotSeries[0];
        
        for(let i = 1; i < hotSeries.length; i++){
            if(hotSeries[i].length > bestHotSeries.length) {
                bestHotSeries = hotSeries[i];
            }
        }

        return bestHotSeries.length;
    }
    function getCurrentHotSeries(hotSeries){
        let currentHotSeries = 0;
        const lastHotSeries = hotSeries[hotSeries.length - 1];
        const lastNote = lastHotSeries[lastHotSeries.length - 1];
        const yesterday = format(subDays(new Date(), 1), 'yyyy-MM-dd');

        if(lastNote && lastNote.fulldate >= yesterday){
            currentHotSeries = lastHotSeries.length;
        }

        return currentHotSeries;
    }
</script>