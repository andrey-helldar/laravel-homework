<template>
    <v-layout justify-center>

        <table-component
                :actions="table.actions"
                :edit-route-name="table.editRouteName"
                :headers="table.headers"
                :messages="table.messages"
                :url="url"
        />

    </v-layout>
</template>
<script type="text/javascript">
    import TableComponent from '../../plugins/_table';

    import Lang from '../../../plugins/lang';

    export default {
        components: {TableComponent},

        data() {
            return {
                url: '/orders',

                table: {
                    headers: [
                        {text: '#', value: 'id'},
                        {text: this.trans('forms.status'), value: 'status'},
                        {text: this.trans('forms.partner'), value: 'partner.name'},
                        {text: this.trans('forms.price'), value: 'price'},
                        {text: this.trans('forms.products'), value: 'products'},
                        {text: this.trans('statuses.deliveryAt'), value: 'delivery_at'},
                        {text: this.trans('statuses.createdAt'), value: 'created_at'},
                        {text: this.trans('statuses.updatedAt'), value: 'updated_at'},
                        {text: this.trans('titles.actions'), value: 'actions'}
                    ],
                    editRouteName: 'orders.edit',
                    actions: ['edit', 'delete'],
                    messages: {
                        loading: this.trans('statuses.retrievingOrderInformation'),
                        loaded: this.trans('statuses.orderInformationReceivedSuccessfully')
                    }
                }
            };
        },

        beforeMount() {
            this.setPageTitle();
        },

        methods: {
            setPageTitle() {
                this.$store.commit('main/pageTitle', this.trans('titles.orders'));
            },

            trans(key) {
                return Lang.get(key);
            }
        }
    };
</script>

<style>
    .snotify-success .snotifyToast__inner {
        color: #C8E6C9;
    }
</style>
