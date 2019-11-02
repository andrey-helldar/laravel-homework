<template>
    <v-container>
        <form :novalidate="false" @submit.prevent="update">
            <v-layout align-start row wrap>
                <v-flex v-if="errors" xs12 md12>
                    <v-container>
                        <errors-component :errors="errors"/>
                    </v-container>
                </v-flex>

                <v-flex xs12 md6>
                    <v-container>
                        <v-layout align-center row wrap>
                            <v-flex xs12 md6>
                                <v-text-field
                                        v-model="form.client_email"
                                        :label="trans('forms.email')"
                                        type="email"
                                        maxlength="255"
                                        counter
                                        required
                                        @change="changed"
                                />
                            </v-flex>

                            <v-flex xs12 md6>
                                <v-select
                                        v-model="form.status"
                                        :items="statuses"
                                        :label="trans('forms.status')"
                                        item-text="value"
                                        item-value="code"
                                        required
                                        @change="changed"
                                />
                            </v-flex>

                            <v-flex xs12 md12>
                                <v-select
                                        v-model="form.partner_id"
                                        :items="partners"
                                        :label="trans('forms.partner')"
                                        item-text="name"
                                        item-value="id"
                                        required
                                        @change="changed"
                                />
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-flex>

                <v-flex xs12 md6>
                    <v-container>
                        <v-card>
                            <v-card-title>
                                <v-text-field
                                        v-model="search"
                                        :label="trans('forms.search')"
                                        append-icon="search"
                                        single-line
                                        hide-details
                                />

                                <v-spacer/>

                                {{ selectedProductsSum }}

                                <v-spacer/>

                                <v-dialog
                                        v-model="dialog.product"
                                        max-width="500px"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-btn
                                                v-on="on"
                                                color="deep-purple"
                                                text
                                                icon
                                        >
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </template>

                                    <v-card>
                                        <v-card-title>
                                            <span class="headline" v-text="trans('info.addProduct')"/>
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

                                                            <v-spacer/>

                                                            <span class="deep-purple--text text--lighten-4" v-text="moneyFormat(item.price)"/>
                                                            <span class="deep-purple--text text--lighten-4" v-text="trans('orders.symbol')"/>
                                                        </template>
                                                    </v-select>
                                                </v-col>

                                                <v-col cols="4">
                                                    <v-text-field
                                                            v-model="itemProductQuantity"
                                                            :label="trans('forms.quantity')"
                                                            type="number"
                                                            min="1"
                                                            required
                                                    />
                                                </v-col>
                                            </v-row>
                                        </v-card-text>

                                        <v-card-actions>
                                            <span class="green--text" v-text="`+${moneyFormat(addProductSum)} ${trans('orders.symbol')}`"/>

                                            <v-spacer/>

                                            <v-btn color="deep-purple darken-1" @click="closeDialog('product')" text v-text="trans('buttons.cancel')"/>
                                            <v-btn color="deep-purple darken-1" @click="addProduct" text v-text="trans('buttons.add')"/>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-card-title>
                            <v-data-table
                                    :headers="tables.products.headers"
                                    :items="form.products"
                                    :search="search"
                                    :loading-text="trans('statuses.loadingProducts')"
                                    :loading="isLoadingProducts"
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

                                <template v-slot:item.pivot.quantity="props">
                                    <v-edit-dialog
                                            :return-value.sync="props.item.pivot.quantity"
                                            persistent
                                            large
                                    >
                                        <v-tooltip top>
                                            <span v-text="trans('info.changeQuantity')"/>

                                            <template v-slot:activator="{ on }">
                                                <span
                                                        v-on="on"
                                                        v-text="props.item.pivot.quantity"
                                                />
                                            </template>
                                        </v-tooltip>

                                        <template v-slot:input>
                                            <v-text-field
                                                    v-model="props.item.pivot.quantity"
                                                    :label="trans('forms.edit')"
                                                    type="number"
                                                    single-line
                                                    required
                                                    @change="changed"
                                            />
                                        </template>
                                    </v-edit-dialog>
                                </template>

                                <template v-slot:item.actions="{ item }">
                                    <v-btn
                                            text
                                            icon
                                            @click="deleteProduct(item)"
                                    >
                                        <icon-delete/>
                                    </v-btn>
                                </template>

                            </v-data-table>
                        </v-card>
                    </v-container>
                </v-flex>

                <v-flex xs12 class="text-center">
                    <v-container>
                        <v-btn
                                :disabled="progress || !isChanged"
                                :loading="progress"
                                type="submit"
                                color="deep-purple white--text"
                        >
                            <v-icon left>save</v-icon>
                            <span v-text="trans('buttons.update')"/>
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

    import axios from '../../../plugins/axios';
    import Lang from '../../../plugins/lang';
    import math from '../../../plugins/math';

    import _ from 'lodash';

    export default {
        components: {ErrorsComponent, IconDelete},

        data() {
            return {
                url: {
                    order: '/orders/:id',
                    partners: '/partners',
                    products: '/products'
                },

                form: {
                    id: null,
                    client_email: null,
                    status: null,
                    partner_id: null,
                    order_products: [],
                    products: []
                },

                statuses: [
                    {code: 0, value: this.trans('orders.status.0')},
                    {code: 10, value: this.trans('orders.status.10')},
                    {code: 20, value: this.trans('orders.status.20')}
                ],

                partners: [],
                products: [],

                tables: {
                    products: {
                        headers: [
                            {text: this.trans('forms.name'), value: 'name'},
                            {text: this.trans('forms.priceForOne'), value: 'price'},
                            {text: this.trans('forms.quantity'), value: 'pivot.quantity'},
                            {text: this.trans('forms.priceForAll'), value: 'priceForAll'},
                            {text: this.trans('titles.actions'), value: 'actions'}
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
                isChanged: false,
                isLoadingProducts: true
            };
        },

        beforeMount() {
            this.getPartners();
            this.getProducts();
            this.getOrder();
        },

        watch: {
            'form.id': {
                deep: true,
                handler(value) {
                    let _title = this.trans('orders.num', {value});

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

                return this.trans('info.total', {value, symbol});
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
            }
        },

        methods: {
            getOrder() {
                let url = this.getUrl(this.url.order);

                axios()
                        .get(url)
                        .messages('statuses.loadingOrder', 'statuses.loadedOrder')
                        .then(response => this.form = response.data)
                        .run();
            },

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

            update() {
                axios()
                        .put(this.getUrl(this.url.order), this.form)
                        .beforeRun(() => {
                            this.progress = true;
                        })
                        .finally(() => {
                            this.progress = false;
                            this.isChanged = false;
                        })
                        .run();
            },

            getUrl(url) {
                let _params = this.$route.params;

                _.each(_params, (value, key) => {
                    url = url.replace(`:${key}`, value);
                });

                return url;
            },

            changed() {
                this.isChanged = true;
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

                    _.set(this, `form.products[${_index}].pivot.quantity`, _quantity);
                }

                this.closeDialog('product');
                this.changed();
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

                this.changed();
            }
        }
    };
</script>

<style scoped>
    h1 {
        margin-bottom: 20px;
    }
</style>
