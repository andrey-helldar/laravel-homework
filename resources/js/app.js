import Vue from 'vue';
import vuetify from './plugins/vuetify';

import App from './components/app';

require('./bootstrap');

window.vm = new Vue({
    el: '#app',
    vuetify,
    render: h => h(App)
});
