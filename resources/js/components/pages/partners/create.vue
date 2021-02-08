<template>
    <v-container>
        <form :novalidate="false" @submit.prevent="store">
            <v-layout column justify-center>
                <v-flex v-if="isNotEmpty(errors)" md12 xs12>
                    <v-container>
                        <errors-component :errors="errors" />
                    </v-container>
                </v-flex>

                <v-flex md6 xs12>
                    <v-text-field
                        v-model="form.email"
                        :label="trans('forms.email')"
                        counter
                        maxlength="255"
                        required
                        type="email"
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

import axios from '../../../plugins/axios';
import Lang from '../../../plugins/lang';

import _ from 'lodash';

export default {
    components: { ErrorsComponent },

    data() {
        return {
            url: '/partners',

            form: {
                email: null,
                name: null
            },

            errors: {},

            progress: false
        };
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
        store() {
            axios()
                .post(this.url, this.form)
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
