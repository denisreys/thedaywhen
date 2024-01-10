<template>
    <div class="mb-5">
        <ul class="flex">
            <li class="mr-5">
                <div class="flex">
                    <div class="mr-1"><iconFire/></div>
                    <div class="text-xl leading-none font-semibold">{{ hotSeries.current }}</div>
                </div>
                <div class="text-xs mt-1 text-center text-small-text dark:text-small-text--dark">Текущий</div>
            </li>
            <li class="mr-5">
                <div class="flex">
                    <div class="mr-1"><iconFire/></div>
                    <div class="text-xl leading-none font-semibold">{{ hotSeries.best }}</div>
                </div>
                <div class="text-xs mt-1 text-center text-small-text dark:text-small-text--dark">Лучший</div>
            </li>
            <li class="mr-4">
                <div class="flex">
                    <div class="mr-1"><iconBook/></div>
                    <div class="text-xl leading-none font-semibold">{{ notesCount }}</div>
                </div>
                <div class="text-xs mt-1 text-center text-small-text dark:text-small-text--dark">Записей</div>
            </li>
        </ul>
    </div>
    <div class="flex flex-col">
        <h2 class="text-lg font-semibold mb-3">Достижения</h2>
        <div class="mb-4">
            <div class="mb-3 text-sm text-small-text dark:text-small-text--dark">В процессе</div>
            <ul>
                <li class="mb-5 overflow-hidden flex" v-for="(achievement, index) in currentAchievements" :key="'c-'+index">
                    <div class="mr-2 xs:mr-3">
                        <component :is="achievement.icon"></component>
                    </div>
                    <ul class="flex-1">
                        <div class="flex justify-between">
                            <div class="text-base font-semibold leading-none">{{ achievement.title }}</div>
                            <div class="text-sm whitespace-nowrap">
                                {{ `${achievement.current} из ${achievement.target}` }}
                            </div>
                        </div>
                        <div class="mb-1 text-sm text-small-text dark:text-small-text--dark">{{ achievement.desc }}</div>
                        <div class="h-4 w-full bg-block-bg dark:bg-block-bg--dark rounded">
                            <div class="bg-main h-full rounded" :style="{ 
                                width: achievement.current < achievement.target 
                                ? achievement.progress+'%'
                                : '100%' 
                            }"></div>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="">
            <div class="mb-3 text-sm text-small-text dark:text-small-text--dark">Завершенные</div>
            <ul>
                <li class="order-1 mb-4 overflow-hidden flex opacity-80" v-for="(achievement, index) in finishedAchievements" :key="'f-'+index">
                    <div class="mr-2 xs:mr-3">
                        <component :is="achievement.icon"></component>
                    </div>
                    <ul class="flex-1">
                        <div class="flex justify-between">
                            <div class="text-base font-semibold leading-none">{{ achievement.title }}</div>
                            <div class="text-sm whitespace-nowrap">Все из всех</div>
                        </div>
                        <div class="mb-1 text-sm text-small-text dark:text-small-text--dark">{{ achievement.desc }}</div>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>
<script setup>
    import iconFire from '../icons/IconFire.vue';
    import iconBook from '../icons/IconBook.vue';
    import { useStore } from 'vuex';
    import { format, parse, addDays, subDays} from 'date-fns';
    import { ref, computed } from 'vue';

    const store = useStore();

    const hotSeries = computed(() => {
        const dividedNotesByHotSeries = divideNotesByHotSeries();

        return {
            best: getBestHotSeries(dividedNotesByHotSeries),
            current: getCurrentHotSeries(dividedNotesByHotSeries)
        }
    });

    const notesCount = computed(() => {
        return store.getters.getNotes.length;
    });

    let achievements = [
        new Achievement(
            'Начинающий записчик',
            'Пишите 7 дней без пропуска.',
            7,
            hotSeries.value.best,
            iconFire
        ),
        new Achievement(
            'Увлеченный хроникер',
            'Пишите 14 дней без пропуска.',
            14,
            hotSeries.value.best,
            iconFire
        ),
        new Achievement(
            'Подающий надежды мемуарист',
            'Пишите 30 дней без пропуска.',
            30,
            hotSeries.value.best,
            iconFire
        ),
        new Achievement(
            'Неутомимый биограф',
            'Пишите 180 дней без пропуска.',
            180,
            hotSeries.value.best,
            iconFire
        ),
        new Achievement(
            'Легендарный летописец',
            'Пишите 365 дней без пропуска.',
            365,
            hotSeries.value.best,
            iconFire
        ),
        new Achievement(
            'Новичок Письменного Искусства',
            'Пишите 50 дней.',
            50,
            notesCount.value,
            iconBook
        ),
        new Achievement(
            'Познающий Азы',
            'Пишите 100 дней.',
            100,
            notesCount.value,
            iconBook
        ),
        new Achievement(
            'Алхимик Слов',
            'Пишите 150 дней.',
            150,
            notesCount.value,
            iconBook
        ),
        new Achievement(
            'Мастер Блокнота',
            'Пишите 200 дней.',
            200,
            notesCount.value,
            iconBook
        ),
        new Achievement(
            'Литературный Волшебник',
            'Пишите 300 дней.',
            300,
            notesCount.value,
            iconBook
        ),
        new Achievement(
            'Император Письма',
            'Пишите 500 дней.',
            500,
            notesCount.value,
            iconBook
        ),
        new Achievement(
            'Всевластный Словесник',
            'Пишите 1000 дней.',
            1000,
            notesCount.value,
            iconBook
        ),
    ]; 

    let currentAchievements = computed(() => {
        let notfinishedAchievements = [...achievements].filter(achievement => achievement.progress < 100);
        return notfinishedAchievements.sort((a, b) => (b.progress - a.progress));
    });
    
    let finishedAchievements = computed(() => {
        return [...achievements].filter(achievement => achievement.progress == 100);
    });

    //METHODS
    function Achievement(title, desc, target, current, icon) {
        this.title = title;
        this.desc = desc;
        this.target = target;
        this.current = current;
        this.icon = icon;

        this.calculateProgress = function() {
            const progressValue = ((this.current / this.target) * 100);
            
            if(progressValue > 100) this.progress = 100;
            else this.progress = progressValue;
        };

        this.calculateProgress();
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

        if(lastNote.fulldate >= yesterday){
            currentHotSeries = lastHotSeries.length;
        }

        return currentHotSeries;
    }
</script>