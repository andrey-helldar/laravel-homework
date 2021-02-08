<template>
    <v-container>
        <form :novalidate="false" @submit.prevent="store">
            <v-layout align-start row wrap>
                <v-flex v-if="isNotEmpty(errors)" md12 xs12>
                    <v-container>
                        <errors-component :errors="errors" />
                    </v-container>
                </v-flex>

                <v-flex md6 xs12>
                    <v-container>
                        <v-layout align-center row wrap>
                            <v-flex md6 xs12>
                                <v-text-field
                                    v-model="form.client_email"
                                    :label="trans('forms.email')"
                                    counter
                                    maxlength="255"
                                    required
                                    type="email"
                                />
                            </v-flex>

                            <v-flex md6 xs12>
                                <v-select
                                    v-model="form.status"
                                    :items="statuses"
                                    :label="trans('forms.status')"
                                    item-text="value"
                                    item-value="code"
                                    required
                                />
                            </v-flex>

                            <v-flex md12 xs12>
                                <v-select
                                    v-model="form.partner_id"
                                    :items="partners"
                                    :label="trans('forms.partner')"
                                    item-text="name"
                                    item-value="id"
                                    required
                                />
                            </v-flex>

                            <v-flex md6 xs12>
                                <v-date-picker
                                    v-model="deliveryAtDate"
                                    :min="minDate()"
                                    first-day-of-week="1"
                                    full-width
                                />
                            </v-flex>

                            <v-flex md6 xs12>
                                <v-time-picker
                                    v-model="deliveryAtTime"
                                    format="24hr"
                                    full-width
                                />
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-flex>

                <v-flex md6 xs12>
                    <v-container>
                        <v-card>
                            <v-card-title>
                                <v-text-field
                                    v-model="search"
                                    :label="trans('forms.search')"
                                    append-icon="search"
                                    hide-details
                                    single-line
                                />

                                <v-spacer />

                                {{ selectedProductsSum }}

                                <v-spacer />

                                <v-dialog
                                    v-model="dialog.product"
                                    max-width="500px"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-btn
                                            v-on="on"
                                            color="deep-purple"
                                            icon
                                            text
                                        >
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </template>

                                    <v-card>
                                        <v-card-title>
                                            <span class="headline" v-text="trans('info.addProduct')" />
                                        </v-card-title>

                                        <v-card-text>
                                            <v-row>
                                                <v-col cols="8">
                                                    <v-select
                                                        v-model="addItem.product.id"
                                                        :items="sortableProducts"
                                                        :label="trans('forms.product')"
                                                        item-text="name"
                                                        item-value="id"
                                                        required
                                                    >
                                                        <template v-slot:item="{ item }">
                                                            {{ item.name }}

                                                            <v-spacer />

                                                            <span class="deep-purple--text text--lighten-4" v-text="moneyFormat(item.price)" />
                                                            <span class="deep-purple--text text--lighten-4" v-text="trans('orders.symbol')" />
                                                        </template>
                                                    </v-select>
                                                </v-col>

                                                <v-col cols="4">
                                                    <v-text-field
                                                        v-model="itemProductQuantity"
                                                        :label="trans('forms.quantity')"
                                                        min="1"
                                                        required
                                                        type="number"
                                                    />
                                                </v-col>
                                            </v-row>
                                        </v-card-text>

                                        <v-card-actions>
                                            <span class="green--text" v-text="`+${moneyFormat(addProductSum)} ${trans('orders.symbol')}`" />

                                            <v-spacer />

                                            <v-btn color="deep-purple darken-1" text @click="closeDialog('product')" v-text="trans('buttons.cancel')" />
                                            <v-btn color="deep-purple darken-1" text @click="addProduct" v-text="trans('buttons.add')" />
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-card-title>
                            <v-data-table
                                :headers="tables.products.headers"
                                :items="form.products"
                                :loading="isLoadingProducts"
                                :loading-text="trans('statuses.loadingProducts')"
                                :search="search"
                            >
                                <template v-slot:no-data>
                                    {{ trans('statuses.noData') }}
                                </template>

                                <template v-slot:item.price="{ item }">
                                    {{ moneyFormat(item.price) }}
                                </template>

                                <template v-slot:item.priceForAll="{ item }">
                                    {{ moneyFormat(item.price * item.pivot.quantity) }}
                                </template>

                                <template v-slot:item.pivot.quantity="{ item }">
                                    <v-btn
                                        :disabled="item.pivot.quantity === 1"
                                        icon
                                        text
                                        @click="productQuantityDecrement(item)"
                                    >
                                        <icon-minus />
                                    </v-btn>

                                    {{ item.pivot.quantity }}

                                    <v-btn
                                        icon
                                        text
                                        @click="productQuantityIncrement(item)"
                                    >
                                        <icon-plus />
                                    </v-btn>
                                </template>

                                <template v-slot:item.actions="{ item }">
                                    <v-btn
                                        icon
                                        text
                                        @click="deleteProduct(item)"
                                    >
                                        <icon-delete />
                                    </v-btn>
                                </template>

                            </v-data-table>
                        </v-card>
                    </v-container>
                </v-flex>

                <v-flex class="text-center" xs12>
                    <v-container>
                        <v-btn
                            :disabled="progress"
                            :loading="progress"
                            color="deep-purple white--text"
                            type="submit"
                        >
                            <v-icon left>save</v-icon>
                            <span v-text="trans('buttons.store')" />
                        </v-btn>
                    </v-container>
                </v-flex>
            </v-layout>
        </form>
    </v-container>
</template>

<script type="text/javascript">
import ErrorsComponent from '../../plugins/_errors';
import IconDelete from '../../plugins/icons/_delete';
import IconPlus from '../../plugins/icons/_plus';
import IconMinus from '../../plugins/icons/_minus';

import axios from '../../../plugins/axios';
import Lang from '../../../plugins/lang';
import math from '../../../plugins/math';
import date from '../../../plugins/date';

import _ from 'lodash';

export default {
    components: { ErrorsComponent, IconDelete, IconPlus, IconMinus },

    data() {
        return {
            url: {
                order: '/orders',
                partners: '/partners',
                products: '/products'
            },

            form: {
                id: null,
                client_email: null,
                status: null,
                partner_id: null,
                order_products: [],
                products: [],
                delivery_at: null
            },

            statuses: [
                { code: 0, value: this.trans('orders.status.0') },
                { code: 10, value: this.trans('orders.status.10') },
                { code: 20, value: this.trans('orders.status.20') }
            ],

            partners: [],
            products: [],

            tables: {
                products: {
                    headers: [
                        { text: this.trans('forms.name'), value: 'name' },
                        { text: this.trans('forms.cost'), value: 'price' },
                        { text: this.trans('forms.quantity'), value: 'pivot.quantity' },
                        { text: this.trans('forms.totalCost'), value: 'priceForAll' },
                        { text: this.trans('titles.actions'), value: 'actions' }
                    ]
                }
            },

            dialog: {
                product: false
            },

            addItem: {
                product: {
                    id: null,
                    quantity: 1,
                    item: {}
                }
            },

            errors: {},
            search: null,

            progress: false,
            isLoadingProducts: true
        };
    },

    beforeMount() {
        this.getPartners();
        this.getProducts();
    },

    watch: {
        'form.id': {
            deep: true,
            handler(value) {
                let _title = this.trans('orders.num', { value });

                this.$store.commit('main/pageTitle', _title);
            }
        }
    },

    computed: {
        selectedProductsSum() {
            let _products = this.form?.products
                ? this.form?.products
                : [];

            let _sum = _.sumBy(_products, product => {
                return product?.price * product?.pivot?.quantity;
            });

            let _locale = this.trans('orders.locale');
            let value = this.moneyFormat(_sum, _locale);
            let symbol = this.trans('orders.symbol');

            return this.trans('info.total', { value, symbol });
        },

        sortableProducts() {
            return _.sortBy(this.products, product => {
                return product.name;
            });
        },

        addProductSum() {
            let _id = this.addItem?.product?.id;
            let _quantity = this.addItem.product.quantity;

            let _product = this.getProductById(_id);

            let _price = _product?.price
                ? _product?.price
                : 0;

            return _price * _quantity;
        },

        itemProductQuantity: {
            get() {
                return this.addItem.product.quantity;
            },

            set(value) {
                this.addItem.product.quantity = parseInt(value);
            }
        },

        deliveryAtDate: {
            get() {
                let _model = this.form?.delivery_at
                    ? this.form?.delivery_at
                    : null;

                return date.getDate(_model);
            },

            set(value) {
                let _model = this.form?.delivery_at
                    ? this.form?.delivery_at
                    : date.get();

                let _arr = _model.split(' ');
                let _time = _.last(_arr);

                this.form.delivery_at = `${ value } ${ _time }`;
            }
        },

        deliveryAtTime: {
            get() {
                let _model = this.form?.delivery_at
                    ? this.form?.delivery_at
                    : null;

                return date.getTime(_model);
            },

            set(value) {
                let _model = this.form?.delivery_at
                    ? this.form?.delivery_at
                    : date.get();

                let _arr = _model.split(' ');
                let _date = _.first(_arr);

                this.form.delivery_at = `${ _date } ${ value }`;
            }
        }
    },

    methods: {
        getPartners() {
            let url = this.getUrl(this.url.partners);

            axios()
                .get(url)
                .messages('statuses.loadingPartners', 'statuses.loadedPartners')
                .then(response => this.partners = response.data)
                .run();
        },

        getProducts() {
            let url = this.getUrl(this.url.products);

            axios()
                .get(url)
                .messages('statuses.loadingProducts', 'statuses.loadedProducts')
                .then(response => {
                    this.products = response.data;
                    this.isLoadingProducts = false;
                })
                .run();
        },

        store() {
            axios()
                .post(this.getUrl(this.url.order), this.form)
                .beforeRun(() => {
                    this.progress = true;
                    this.errors = {};
                })
                .catch(errors => this.errors = errors)
                .finally(() => this.progress = false)
                .run();
        },

        getUrl(url) {
            let _params = this.$route.params;

            _.each(_params, (value, key) => {
                url = url.replace(`:${ key }`, value);
            });

            return url;
        },

        trans(key, replacements = {}) {
            return Lang.get(key, replacements);
        },

        moneyFormat(value) {
            return math.moneyFormat(value, this.trans('orders.locale'));
        },

        closeDialog(key) {
            _.set(this.dialog, key, false);
        },

        addProduct() {
            let _productId = this.addItem?.product?.id
                ? this.addItem?.product?.id
                : null;

            let _quantity = this.addItem?.product?.quantity
                ? this.addItem?.product?.quantity
                : null;

            let _product = this.getProductById(_productId);

            let _pivot = {
                price: _product?.price,
                quantity: _quantity
            };

            _.set(_product, 'pivot', _pivot);

            let _formProduct = this.getProductById(_productId, this.form.products);

            if (_.isUndefined(_formProduct)) {
                this.form.products.push(_product);
            } else {
                let _index = this.form.products.indexOf(_formProduct);

                _quantity += _formProduct.pivot.quantity;

                _.set(this, `form.products[${ _index }].pivot.quantity`, _quantity);
            }

            this.closeDialog('product');
        },

        getProductById(id, items = null) {
            items = _.isNull(items)
                ? this.products
                : items;

            return _.find(items, product => {
                return product.id === id;
            });
        },

        deleteProduct(item) {
            let _index = this.form.products.indexOf(item);

            this.form.products.splice(_index, 1);
        },

        productQuantityIncrement(item) {
            let _quantity = _.isNumber(item?.pivot?.quantity)
                ? item?.pivot?.quantity
                : parseInt(item?.pivot?.quantity);

            let _index = this.form.products.indexOf(item);

            _.set(this, `form.products[${ _index }].pivot.quantity`, _quantity + 1);
        },

        productQuantityDecrement(item) {
            let _quantity = _.isNumber(item?.pivot?.quantity)
                ? item?.pivot?.quantity
                : parseInt(item?.pivot?.quantity);

            let _index = this.form.products.indexOf(item);

            _quantity = _quantity - 1 < 1 ? 1 : _quantity - 1;

            _.set(this, `form.products[${ _index }].pivot.quantity`, _quantity);
        },

        minDate() {
            return new Date().toISOString().substr(0, 10);
        },

        isNotEmpty(value) {
            return ! _.isEmpty(value);
        }
    }
};
</script>
