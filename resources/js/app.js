import Vue from 'vue';
import vuetify from './plugins/vuetify';
import store from './plugins/store/index';
import router from './plugins/routes';

import App from './components/app';

require('./bootstrap');

window.vm = new Vue({
    el: '#app',
    router,
    vuetify,
    store,
    render: h => h(App)
});
