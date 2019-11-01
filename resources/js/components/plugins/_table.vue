<template>
    <v-data-table
            :headers="headers"
            :items="items"
            :items-per-page-options="rowsPerPageItems"
            :search="search"
            item-key="title"
            calculate-widths
            class="full-width"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-text-field
                        :label="trans('forms.search')"
                        append-icon="search"
                        hide-defails
                        single-line
                        v-model="search"
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
                {{ sumProducts(item.products) }}
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
                <status-chip-new v-if="item.status === 0"/>
                <status-chip-accepted v-if="item.status === 10"/>
                <status-chip-finished v-if="item.status === 20"/>
            </router-link>
        </template>

        <template v-slot:item.actions="{ item }">
            <v-btn
                    :to="{name: editRouteName, params: {id: item.id}}"
                    text
                    v-if="isShowAction('edit')"
            >
                <icon-edit/>
            </v-btn>

            <v-btn
                    @click="destroy(item.id)"
                    text
                    v-if="isShowAction('destroy')"
            >
                <icon-delete/>
            </v-btn>

            <v-dialog
                    max-width="500"
                    v-if="isShowAction('delete')"
                    v-model="dialogs[item.id]"
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                            text
                            v-on="on"
                    >
                        <icon-delete/>
                    </v-btn>
                </template>

                <v-card>
                    <v-card-title class="headline">
                        {{ trans('titles.confirm') }}

                        <v-spacer/>

                        <v-btn
                                @click="closeDialog(item.id)"
                                text
                        >
                            <v-icon color="grey darken-1">close</v-icon>
                        </v-btn>
                    </v-card-title>

                    <v-card-text v-text="trans('info.confirm.delete')"/>

                    <v-divider/>

                    <v-card-actions>
                        <v-spacer/>
                        <v-btn @click="destroy(item.id)" text v-text="trans('buttons.delete')"/>
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
        props: ['headers', 'url', 'edit-route-name', 'actions', 'messages'],

        components: {IconDelete, IconEdit, StatusChipNew, StatusChipAccepted, StatusChipFinished},

        data() {
            return {
                items: [],

                rowsPerPageItems: [
                    10, 25, 50,
                    {'text': this.trans('buttons.rowsPerPage'), 'value': -1}
                ],

                search: null,

                dialogs: {}
            };
        },
        beforeMount() {
            this.get();
        },
        methods: {
            get() {
                axios()
                    .get(this.fixUrl())
                    .messages(this.messages?.loading, this.messages?.loaded)
                    .then(response => this.items = response.data)
                    .run();
            },

            destroy(id) {
                console.log(this.fixUrl(id));
                axios()
                    .delete(this.fixUrl(id))
                    .messages(this.messages?.deleting, this.messages?.deleted)
                    .then(() => {
                        this.closeDialog(id);
                        this.get();
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
                let locale = this.trans('orders.locale');

                let sum = _.sumBy(products, obj => {
                    return obj?.price * obj?.pivot?.quantity;
                });

                return math.moneyFormat(sum, locale);
            },

            strRandom() {
                return str.random();
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
    .full-width {
        width: 100%;
    }

    .products {
        margin-bottom: 0;
    }

    .link-as-text {
        color: #000;
        cursor: pointer;
        text-decoration: none;

        .v-chip__content {
            cursor: inherit;
        }
    }
</style>
