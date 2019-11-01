export default {
    namespaced: true,

    state: {
        pageTitle: null,
        drawler: null
    },
    getters: {
        pageTitle: state => {
            return state.pageTitle;
        },

        drawler: state => {
            return state.drawler;
        }
    },
    mutations: {
        pageTitle(state, value) {
            state.pageTitle = value;
        },

        drawler(state, value) {
            state.drawler = value;
        }
    }

};
