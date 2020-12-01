require('./bootstrap');

import '../css/app.css';
require('../css/app.scss');
const $ = require('jquery');

import Vue from 'vue';
import VueClipboard from 'vue-clipboard2';
import Route from '../js/router.js';
import App from '../js/views/App.vue';
import VueSweetalert2 from 'vue-sweetalert2';

Vue.component('video-component', require('./components/video.vue').default);
VueClipboard.config.autoSetContainer = true;
Vue.use(VueClipboard);
Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',
    router: Route,
    render: h => h(App),
});

export default app;