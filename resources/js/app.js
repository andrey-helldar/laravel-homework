import Vue from 'vue';
import vuetify from './plugins/vuetify';
import store from './plugins/store/index';

import App from './components/layout/app';

require('./bootstrap');

window.vm = new Vue({
    el: '#app',
    vuetify,
    store,
    render: h => h(App)
});
