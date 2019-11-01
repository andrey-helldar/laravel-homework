import 'nprogress/nprogress.css';

import Vue from 'vue';
import VueRouter from 'vue-router';
import NProgress from 'nprogress';

import routes from './_routes';

Vue.use(VueRouter);

const router = new VueRouter({
    linkActiveClass: 'active',
    routes
});

router.beforeEach((to, from, next) => {
    NProgress.start();
    next();
});

router.afterEach((to, from) => {
    NProgress.done();
});

export default router;
