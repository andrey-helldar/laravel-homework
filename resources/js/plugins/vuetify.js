import 'material-design-icons-iconfont/dist/material-design-icons.css';
import 'vuetify/dist/vuetify.css';

import Vue from 'vue';
import Vuetify from 'vuetify';

Vue.use(Vuetify);

const opts = {
    icons: {
        iconfont: 'md'
    }
};

export default new Vuetify(opts);
