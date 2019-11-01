<template>
    <v-list-item two-line>
        <v-list-item-avatar v-if="icon">
            <img :src="icon" alt="icon">
        </v-list-item-avatar>

        <v-list-item-content>
            <v-list-item-title class="title" v-text="temp"/>
            <v-list-item-subtitle v-text="updatedAt"/>
        </v-list-item-content>
    </v-list-item>
</template>

<script>
    import Lang from '../../plugins/lang';
    import axios from '../../plugins/axios';
    import date from '../../plugins/date';

    import _ from 'lodash';

    export default {
        data() {
            return {
                url: {
                    data: '/weather',
                    icon: 'https://yastatic.net/weather/i/icons/blueye/color/svg/%s.svg'
                },

                item: {
                    now_dt: null,
                    fact: {
                        season: '---',
                        temp: '---',
                        icon: null
                    }
                },

                statuses: {
                    loading: this.trans('statuses.gettingWeatherInformation'),
                    loaded: this.trans('statuses.weatherInformationSuccessfullyReceived')
                }
            };
        },

        mounted() {
            this.get();
        },

        computed: {
            temp() {
                return this.item.fact.temp + ' ℃';
            },

            icon() {
                return this.item.fact.icon
                        ? this.url.icon.replace('%s', this.item.fact.icon)
                        : null;
            },

            updatedAt() {
                return date.get(this.item.now_dt);
            }
        },

        methods: {
            get() {
                axios()
                        .get(this.url.data)
                        .messages(this.statuses.loading, this.statuses.loaded)
                        .then(response => {
                            _.set(this, 'item',
                                    _.merge(this.item, response.data)
                            );
                        })
                        .run();
            },

            trans(key) {
                return Lang.get(key);
            }
        }
    };
</script>
