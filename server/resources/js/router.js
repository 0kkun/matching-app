import Vue from 'vue';
import Router from 'vue-router';

import SystemError from './pages/errors/System.vue'
import Search from './pages/Search.vue'

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'Search',
            component: Search
        },
        {
            path: '/home/500',
            component: SystemError
        },
    ]
});