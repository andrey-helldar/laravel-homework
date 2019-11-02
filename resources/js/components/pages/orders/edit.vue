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
                                {{ selectedProductsSum }}

                                <v-spacer/>

                                <v-text-field
                                        v-model="search"
                                        :label="trans('forms.search')"
                                        append-icon="search"
                                        single-line
                                        hide-details
                                />
                            </v-card-title>
                            <v-data-table
                                    :headers="tables.products.headers"
                                    :items="form.products"
                                    :search="search"
                            >
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
                                        {{ props.item.pivot.quantity }}

                                        <template v-slot:input>
                                            <v-text-field
                                                    v-model="props.item.pivot.quantity"
                                                    :label="trans('forms.edit')"
                                                    type="numeric"
                                                    single-line
                                                    required
                                                    @change="changed"
                                            />
                                        </template>
                                    </v-edit-dialog>
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

    import axios from '../../../plugins/axios';
    import Lang from '../../../plugins/lang';
    import math from '../../../plugins/math';

    import _ from 'lodash';

    export default {
        components: {ErrorsComponent},

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
                            {text: this.trans('forms.priceForAll'), value: 'priceForAll'}
                        ]
                    }
                },

                errors: {},
                search: null,

                progress: false,
                isChanged: false
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
                        .then(response => this.products = response.data)
                        .run();
            },

            update() {
                this.progress = true;
            },

            getUrl(url, id = null) {
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
            }
        }
    };
</script>

<style scoped>
    h1 {
        margin-bottom: 20px;
    }
</style>
