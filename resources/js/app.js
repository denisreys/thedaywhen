import {createApp} from 'vue';
import router from './router.js';
import { createStore } from 'vuex';
import App from './layouts/App.vue';
import axios from 'axios';
import { format } from 'date-fns';


const store = createStore({
    state () {
        return {
            notes: [],
            loaders: {
                content: true,
            }
        }
    },
    mutations: {
        setNotes(state, payload) {
            state.notes = payload;
        },
        setNote(state, payload){
            const index = state.notes.findIndex(note => note.fulldate === payload.fulldate);

            if(index === -1) {
                state.notes[state.notes.length] = payload;
            }else {
                if(payload.text.length < 1) {
                    state.notes.splice(index, 1);
                }else {
                    state.notes[index] = { ...state.notes[index], ...payload };
                }
            }

            this.commit('sortNotesByDate');
        },
        sortNotesByDate(state) {
            state.notes.sort((a, b) => new Date(a.fulldate) - new Date(b.fulldate));
        },
    },
    actions: {
        loadNotes({ commit }) {
            return axios
                    .get('/notes')
                    .then(res => {
                        commit('setNotes', res.data);
                        return res.data;
                    })
                    .catch(error => console.log(error))
        },
        sortNotes(state){
            this.commit('sortNotesByDate');
        }
    },
    getters: {
        getNotes(state){
            return state.notes;
        },
        getNotesByFilters: (state) => (filters) => {
            const startDateRightFormat = format(filters.date.start, 'yyyy-MM-dd');
            const endDateRightFormat = format(filters.date.end, 'yyyy-MM-dd');

            const filteredNotes = state.notes.filter(function(note) {
                if(filters.bookmated && !note.bookmated) {
                    return false;
                }
                if(!(note.fulldate <= startDateRightFormat && 
                        note.fulldate >= endDateRightFormat)){
                    return false;
                }
                
                return note;
            });

            return filteredNotes;
        },
        getBookmatedNotes: (state) => {
            return state.notes.filter((note) => note.bookmated);
        }
    }
})

const app = createApp(App);
app.use(router)
   .use(store)
   .mount('#app');