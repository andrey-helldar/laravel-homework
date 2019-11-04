<template>
    <v-container>
        <form :novalidate="false" @submit.prevent="store">
            <v-layout justify-center column>
                <v-flex v-if="isNotEmpty(errors)" xs12 md12>
                    <v-container>
                        <errors-component :errors="errors"/>
                    </v-container>
                </v-flex>

                <v-flex xs12 md6>
                    <v-select
                            v-model="form.vendor_id"
                            :items="vendors"
                            :label="trans('forms.vendor')"
                            item-text="name"
                            item-value="id"
                            required
                    />
                </v-flex>

                <v-flex xs12 md6>
                    <v-text-field
                            v-model="form.name"
                            :label="trans('forms.name')"
                            maxlength="255"
                            counter
                            required
                    />
                </v-flex>

                <v-flex xs12 md6>
                    <v-text-field
                            v-model="form.price"
                            :label="trans('forms.price')"
                            type="number"
                            min="1"
                            required
                    />
                </v-flex>

                <v-flex xs12 class="text-center">
                    <v-container>
                        <v-btn
                                :disabled="progress"
                                :loading="progress"
                                type="submit"
                                color="deep-purple white--text"
                        >
                            <v-icon left>save</v-icon>
                            <span v-text="trans('buttons.store')"/>
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

    import _ from 'lodash';

    export default {
        components: {ErrorsComponent},

        data() {
            return {
                url: {
                    products: '/products',
                    vendors: '/vendors'
                },

                form: {
                    name: null,
                    price: null,
                    vendor_id: null
                },

                vendors: [],

                errors: {},

                progress: false
            };
        },

        beforeMount() {
            this.getVendors();
        },

        watch: {
            'form.name': {
                deep: true,
                handler(value) {
                    this.$store.commit('main/pageTitle', value);
                }
            }
        },

        methods: {
            getVendors() {
                axios()
                        .get(this.url.vendors)
                        .messages('statuses.loadingVendors', 'statuses.loadedVendors')
                        .then(response => this.vendors = response.data)
                        .run();
            },

            store() {
                axios()
                        .post(this.url.products, this.form)
                        .beforeRun(() => {
                            this.progress = true;
                            this.errors = {};
                        })
                        .catch(errors => this.errors = errors)
                        .finally(() => this.progress = false)
                        .run();
            },

            trans(key) {
                return Lang.get(key);
            },

            isNotEmpty(value) {
                return ! _.isEmpty(value);
            }
        }
    };
</script>
