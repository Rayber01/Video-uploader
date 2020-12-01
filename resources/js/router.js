import Vue from 'vue';
import VueRouter from 'vue-router';

import Upload from '../js/pages/Upload.vue';
import Login from '../js/pages/Login.vue';
import NotFound from '../js/pages/Notfound.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
        	path: '/',
        	name: 'upload',
        	component: Upload
        },
        {
        	path: '/login',
        	name: 'login',
        	component: Login
        },
        {
            path: '*',
            name: 'not found',
            component: NotFound
        }
    ]
});

export default router;