<template>
    <v-layout justify-center>
        <form :novalidate="false" @submit.prevent="update">
            <v-layout align-center row wrap>
                <v-flex s12 md12 v-if="pageTitle">
                    <h1 v-text="pageTitle"/>
                </v-flex>

                <v-flex v-if="errors" xs12 md12>
                    <errors-component :errors="errors"/>
                </v-flex>

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

                <v-flex xs12 md12>
                    <v-select
                            v-model="selectedProducts"
                            :items="products"
                            :label="trans('forms.products')"
                            :hint="productsSum"
                            item-text="name"
                            item-value="id"
                            persistent-hint
                            multiple
                            chips
                            @change="changed"
                    />
                </v-flex>

                <v-flex xs12 class="text-center">
                    <v-btn
                            :disabled="progress || !isChanged"
                            :loading="progress"
                            type="submit"
                            color="deep-purple white--text"
                    >
                        <v-icon left>save</v-icon>
                        <span v-text="trans('buttons.update')"/>
                    </v-btn>
                </v-flex>
            </v-layout>
        </form>
    </v-layout>
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

                errors: {},

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
            pageTitle: {
                get() {
                    return this.$store.getters['main/pageTitle'];
                },
                set() {
                }
            },

            selectedProducts: {
                get() {
                    let _items = this.form?.order_products
                            ? this.form?.order_products
                            : [];

                    return _.uniq(
                            _.flatMap(_items, item => {
                                return item.id;
                            })
                    );
                },
                set(values) {
                    this.form.order_products =
                            _.uniq(
                                    _.filter(this.products, product => {
                                        return _.indexOf(values, product.id) > -1;
                                    })
                            );
                }
            },

            productsSum() {
                let _products = this.form?.order_products
                        ? this.form?.order_products
                        : [];

                let _filtered = _.filter(_products, item => {
                    return _.indexOf(this.selectedProducts, item.id) > -1;
                });

                let _sum = _.sumBy(_filtered, item => {
                    return item.price;
                });

                let locale = this.trans('orders.locale');

                return this.trans('orders.selectedProductsWorth', {
                    value: math.moneyFormat(_sum, locale),
                    symbol: this.trans('orders.symbol')
                });
            }
        },

        methods: {
            getOrder() {
                let url = this.getUrl(this.url.order);

                axios()
                        .get(url)
                        .then(response => this.form = response.data)
                        .run();
            },

            getPartners() {
                let url = this.getUrl(this.url.partners);

                axios()
                        .get(url)
                        .then(response => this.partners = response.data)
                        .run();
            },

            getProducts() {
                let url = this.getUrl(this.url.products);

                axios()
                        .get(url)
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
            }
        }
    };
</script>

<style scoped>
    h1 {
        margin-bottom: 20px;
    }
</style>
