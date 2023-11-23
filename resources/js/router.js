import { createWebHistory, createRouter } from 'vue-router';
import Dashboard from './components/Dashboard.vue';
import Auth from './components/Auth.vue';

const routes = [
    { 
        path: '/',
        name: 'dashboard',
        component: Dashboard,
        meta: {requiresAuth: true} 
    },
    { 
        path: '/auth',
        name: 'auth',
        component: Auth,
        meta: {requiresAuth: false} 
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// router.beforeEach((to,from) => {
//     if(to.meta.requiresAuth && !localStorage.getItem('token'))
//         return {name: 'auth'}
//     if(to.meta.requiresAuth == false && localStorage.getItem('token'))
//        return {name: 'dashboard'}   
// });

export default router;