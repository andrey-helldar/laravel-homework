<template>
    <v-container>
        <form :novalidate="false" @submit.prevent="update">
            <v-layout column justify-center>
                <v-flex v-if="isNotEmpty(errors)" md12 xs12>
                    <v-container>
                        <errors-component :errors="errors" />
                    </v-container>
                </v-flex>

                <v-flex md6 xs12>
                    <v-text-field
                        v-model="form.vendor.name"
                        :label="trans('forms.vendor')"
                        disabled
                    />
                </v-flex>

                <v-flex md6 xs12>
                    <v-text-field
                        v-model="form.name"
                        :label="trans('forms.name')"
                        counter
                        maxlength="255"
                        required
                    />
                </v-flex>

                <v-flex md6 xs12>
                    <v-text-field
                        v-model="form.price"
                        :label="trans('forms.price')"
                        min="1"
                        required
                        type="number"
                    />
                </v-flex>

                <v-flex class="text-center" xs12>
                    <v-container>
                        <v-btn
                            :disabled="progress || !isChanged"
                            :loading="progress"
                            color="deep-purple white--text"
                            type="submit"
                        >
                            <v-icon left>save</v-icon>
                            <span v-text="trans('buttons.update')" />
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
    components: { ErrorsComponent },

    data() {
        return {
            url: '/products/:id',

            form: {
                name: null,
                price: null,
                vendor: { name: null }
            },

            errors: {},

            progress: false,
            isChanged: false
        };
    },

    beforeMount() {
        this.get();
    },

    watch: {
        'form.name': {
            deep: true,
            handler(value) {
                this.$store.commit('main/pageTitle', value);
            }
        },

        'form': {
            deep: true,
            handler(value) {
                this.isChanged = true;
            }
        }
    },

    methods: {
        get() {
            let url = this.getUrl(this.url);

            axios()
                .get(url)
                .messages('statuses.loadingProduct', 'statuses.loadedProduct')
                .then(response => this.form = response.data)
                .finally(() => this.isChanged = false)
                .run();
        },

        update() {
            let url = this.getUrl(this.url);

            axios()
                .put(url, this.form)
                .beforeRun(() => {
                    this.progress = true;
                    this.errors = {};
                })
                .then(() => this.isChanged = false)
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

        trans(key) {
            return Lang.get(key);
        },

        isNotEmpty(value) {
            return ! _.isEmpty(value);
        }
    }
};
</script>
