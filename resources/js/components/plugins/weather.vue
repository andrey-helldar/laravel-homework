<template>
    <v-list-item two-line>
        <v-list-item-avatar v-if="icon">
            <img :src="icon" alt="icon">
        </v-list-item-avatar>

        <v-list-item-content>
            <v-list-item-title class="title" v-text="temp" />
            <v-list-item-subtitle v-text="updatedAt" />
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
                loading: this.trans('statuses.loadingWeather'),
                loaded: this.trans('statuses.loadedWeather')
            }
        };
    },

    mounted() {
        this.get();
        this.autoUpdate();
    },

    computed: {
        temp() {
            const temp = this.item?.fact?.temp || '---';

            return temp + ' ℃';
        },

        icon() {
            return this.item?.fact?.icon
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
                .then(response => this.item = _.merge(this.items, response.data))
                .run();
        },

        autoUpdate() {
            setInterval(() => {
                this.get();
            }, 1000 * 60 * 5);
        },

        trans(key) {
            return Lang.get(key);
        }
    }
};
</script>
