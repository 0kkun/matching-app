import Vue from 'vue';
import Router from 'vue-router';

import SystemError from './pages/errors/System.vue'
import Search from './pages/Search.vue'
import Profile from './pages/Profile.vue'
import Message from './pages/Message.vue'
import Like from './pages/Like.vue'
import Community from './pages/Community.vue'

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
            path: '/home/profile',
            name: 'Profile',
            component: Profile
        },
        {
            path: '/home/message',
            name: 'Message',
            component: Message
        },
        {
            path: '/home/like',
            name: 'Like',
            component: Like
        },
        {
            path: '/home/community',
            name: 'Community',
            component: Community
        },
        {
            path: '/home/500',
            component: SystemError
        },
    ]
});