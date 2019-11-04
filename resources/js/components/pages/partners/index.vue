<template>
    <table-component
            :actions="table.actions"
            :edit-route-name="table.editRouteName"
            :headers="table.headers"
            :items="items"
            :messages="table.messages"
            :url="url"
    />
</template>
<script type="text/javascript">
    import TableComponent from '../../plugins/_table';

    import Lang from '../../../plugins/lang';
    import axios from '../../../plugins/axios';

    export default {
        components: {TableComponent},

        data() {
            return {
                url: '/partners',

                table: {
                    headers: [
                        {text: '#', value: 'id'},
                        {text: this.trans('forms.name'), value: 'name'},
                        {text: this.trans('forms.email'), value: 'email'},
                        {text: this.trans('titles.actions'), value: 'actions'}
                    ],
                    editRouteName: 'partners.edit',
                    actions: ['edit', 'delete'],
                    messages: {
                        loading: this.trans('statuses.loadingPartners'),
                        loaded: this.trans('statuses.loadedPartners')
                    }
                },

                items: []
            };
        },

        beforeMount() {
            this.setPageTitle();
            this.get();
        },

        methods: {
            get() {
                axios()
                        .get(this.url)
                        .messages(this.table?.messages?.loading, this.table?.messages?.loaded)
                        .then(response => this.items = response.data)
                        .run();
            },

            setPageTitle() {
                this.$store.commit('main/pageTitle', this.trans('titles.partners'));
            },

            trans(key) {
                return Lang.get(key);
            }
        }
    };
</script>
