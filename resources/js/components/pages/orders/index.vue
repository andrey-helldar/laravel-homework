<template>
    <v-tabs
        background-color="transparent"
        centered
    >
        <v-tabs-slider />

        <v-tab
            v-for="tab in tabs"
            :key="tab.id"
            :href="`#tab-${tab.id}`"
            v-text="tab.title"
        />

        <v-tab-item
            v-for="tab in tabs"
            :key="tab.id"
            :value="`tab-${tab.id}`"
        >
            <table-component
                :actions="table.actions"
                :edit-route-name="table.editRouteName"
                :headers="table.headers"
                :items="tab.items()"
                :messages="table.messages"
                :url="url"
            />
        </v-tab-item>

    </v-tabs>
</template>
<script type="text/javascript">
import TableComponent from '../../plugins/_table';

import Lang from '../../../plugins/lang';
import axios from '../../../plugins/axios';
import date from '../../../plugins/date';

import _ from 'lodash';

export default {
    components: { TableComponent },

    data() {
        return {
            url: '/orders',

            table: {
                headers: [
                    { text: '#', value: 'id' },
                    { text: this.trans('forms.status'), value: 'status' },
                    { text: this.trans('forms.partner'), value: 'partner.name' },
                    { text: this.trans('forms.price'), value: 'price' },
                    { text: this.trans('forms.products'), value: 'products' },
                    { text: this.trans('forms.deliveryAt'), value: 'delivery_at' },
                    { text: this.trans('statuses.createdAt'), value: 'created_at' },
                    { text: this.trans('statuses.updatedAt'), value: 'updated_at' },
                    { text: this.trans('titles.actions'), value: 'actions' }
                ],
                editRouteName: 'orders.edit',
                actions: ['edit', 'delete'],
                messages: {
                    loading: this.trans('statuses.loadingOrders'),
                    loaded: this.trans('statuses.loadedOrders')
                }
            },

            tabs: [
                {
                    id: 'all',
                    title: this.trans('titles.all'),
                    items: () => this.items
                },

                {
                    id: 'new',
                    title: this.trans('titles.new'),
                    items: () => _.filter(this.items, item => item.delivery_at > date.get() && item.status === 0)
                },

                {
                    id: 'pastDue',
                    title: this.trans('titles.pastDue'),
                    items: () => _.filter(this.items, item => item.delivery_at < date.get() && item.status === 10)
                },

                {
                    id: 'current',
                    title: this.trans('titles.current'),
                    items: () => _.filter(this.items, item => {
                        let _date = new Date();
                        _date.setHours(_date.getHours() - 24);

                        return item.delivery_at >= date.get(_date) && item.status === 10;
                    })
                },

                {
                    id: 'completed',
                    title: this.trans('titles.completed'),
                    items: () => _.filter(this.items, item => {
                        let _date = date.getDate();
                        let _start = `${ _date } 00:00:00`;
                        let _end = `${ _date } 23:59:59`;

                        return _start <= item.delivery_at && item.delivery_at <= _end && item.status === 20;
                    })
                }
            ],

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
            this.$store.commit('main/pageTitle', this.trans('titles.orders'));
        },

        trans(key) {
            return Lang.get(key);
        }
    }
};
</script>
