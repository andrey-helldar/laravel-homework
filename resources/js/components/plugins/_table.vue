<template>
    <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="items"
        :search="search"
        calculate-widths
        item-key="title"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-text-field
                    v-model="search"
                    :label="trans('forms.search')"
                    append-icon="search"
                    hide-defails
                    single-line
                />
            </v-toolbar>
        </template>

        <template v-slot:item.partner.name="{ item }">
            <router-link
                :to="{name: editRouteName, params: {id: item.id}}"
                class="link-as-text"
                v-text="item.partner.name"
            />
        </template>

        <template v-slot:item.price="{ item }">
            <router-link
                :to="{name: editRouteName, params: {id: item.id}}"
                class="link-as-text"
            >
                {{ moneyFormat(sumProducts(item.products)) }}
                {{ trans('orders.symbol') }}
            </router-link>
        </template>

        <template v-slot:item.price.one="{ item }">
            <router-link
                :to="{name: editRouteName, params: {id: item.id}}"
                class="link-as-text"
            >
                {{ moneyFormat(item.price) }}
                {{ trans('orders.symbol') }}
            </router-link>
        </template>

        <template v-slot:item.products="{ item }">
            <p
                v-for="product in item.products"
                :key="strRandom()"
                class="products"
            >
                <router-link
                    :to="{name: editRouteName, params: {id: item.id}}"
                    class="link-as-text"
                    v-text="product.name"
                />
            </p>
        </template>

        <template v-slot:item.status="{ item }">
            <router-link
                :to="{name: editRouteName, params: {id: item.id}}"
                class="link-as-text"
            >
                <status-chip-new v-if="item.status === 0" />
                <status-chip-accepted v-if="item.status === 10" />
                <status-chip-finished v-if="item.status === 20" />
            </router-link>
        </template>

        <template v-slot:item.actions="{ item }">
            <v-btn
                v-if="isShowAction('edit')"
                :to="{name: editRouteName, params: {id: item.id}}"
                text
            >
                <icon-edit />
            </v-btn>

            <v-btn
                v-if="isShowAction('destroy')"
                text
                @click="destroy(item.id)"
            >
                <icon-delete />
            </v-btn>

            <v-dialog
                v-if="isShowAction('delete')"
                v-model="dialogs[item.id]"
                max-width="500"
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                        v-on="on"
                        text
                    >
                        <icon-delete />
                    </v-btn>
                </template>

                <v-card>
                    <v-card-title class="headline">
                        {{ trans('titles.confirm') }}

                        <v-spacer />

                        <v-btn
                            text
                            @click="closeDialog(item.id)"
                        >
                            <v-icon color="grey darken-1">close</v-icon>
                        </v-btn>
                    </v-card-title>

                    <v-card-text v-text="trans('info.confirm.delete')" />

                    <v-divider />

                    <v-card-actions>
                        <v-spacer />
                        <v-btn text @click="destroy(item.id)" v-text="trans('buttons.delete')" />
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>
    </v-data-table>
</template>
<script type="text/javascript">
import IconDelete from './icons/_delete';
import IconEdit from './icons/_edit';

import StatusChipNew from './statuses/_new';
import StatusChipAccepted from './statuses/_accepted';
import StatusChipFinished from './statuses/_finished';

import Lang from '../../plugins/lang';
import axios from '../../plugins/axios';
import math from '../../plugins/math';
import str from '../../plugins/str';

import _ from 'lodash';

export default {
    props: ['headers', 'items', 'url', 'edit-route-name', 'actions', 'messages'],

    components: { IconDelete, IconEdit, StatusChipNew, StatusChipAccepted, StatusChipFinished },

    data() {
        return {
            footerProps: {
                itemsPerPageOptions: [
                    10, 25, 50,
                    { 'text': this.trans('buttons.all'), 'value': -1 }
                ]
            },

            search: null,

            dialogs: {}
        };
    },
    methods: {
        destroy(id) {
            axios()
                .delete(this.fixUrl(id))
                .messages(this.messages?.deleting, this.messages?.deleted)
                .beforeRun(() => this.closeDialog(id))
                .then(() => {
                    let _item = _.find(this.items, item => item.id === id);
                    let _index = this.items.indexOf(_item);
                    this.items.splice(_index, 1);
                })
                .run();
        },

        closeDialog(id) {
            _.set(this.dialogs, id, false);
        },

        trans(key) {
            return Lang.get(key);
        },

        value(obj, key) {
            return _.get(obj, key);
        },

        isShowAction(key) {
            return _.indexOf(this.actions, key) > -1;
        },

        sumProducts(products) {
            return _.sumBy(products, obj => {
                return obj?.price * obj?.pivot?.quantity;
            });
        },

        strRandom() {
            return str.random();
        },

        moneyFormat(value) {
            let locale = this.trans('orders.locale');

            return math.moneyFormat(value, locale);
        },

        fixUrl(id = null) {
            let _url = _.endsWith(this.url, '/')
                ? this.url
                : this.url + '/';

            return _.isNull(id)
                ? _url
                : _url + id;
        }
    }
};
</script>

<style lang="scss" scoped>
.products {
    margin-bottom: 0;
}

.link-as-text {
    cursor: pointer;
    text-decoration: none;
    color: #000000;

    .v-chip__content {
        cursor: inherit;
    }
}
</style>
