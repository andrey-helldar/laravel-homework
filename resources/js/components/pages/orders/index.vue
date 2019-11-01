<template>
    <v-layout justify-center>

        <table-component
                :actions="table.actions"
                :edit-route-name="table.editRouteName"
                :headers="table.headers"
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
                        {text: this.trans('titles.actions'), value: 'actions'}
                    ],
                    editRouteName: 'orders.edit',
                    actions: ['edit', 'delete']
                }
            };
        },

        methods: {
            trans(key) {
                return Lang.get(key);
            }
        }
    };
</script>
