<template>
    <v-list-item two-line>
        <v-list-item-avatar v-if="icon">
            <img :src="icon" alt="icon">
        </v-list-item-avatar>

        <v-list-item-content>
            <v-list-item-title class="title" v-text="item.fact.season"/>
            <v-list-item-subtitle v-text="temp"/>
        </v-list-item-content>
    </v-list-item>
</template>

<script>
    import axios from '../../plugins/axios';

    import _ from 'lodash';

    export default {
        data() {
            return {
                url: {
                    data: '/weather',
                    icon: 'https://yastatic.net/weather/i/icons/blueye/color/svg/%s.svg'
                },

                item: {
                    fact: {
                        season: '---',
                        temp: '---',
                        icon: null
                    }
                }
            };
        },

        mounted() {
            this.get();
        },

        computed: {
            temp() {
                return this.item.fact.temp + '℃';
            },

            icon() {
                return this.item.fact.icon
                    ? this.url.icon.replace('%s', this.item.fact.icon)
                    : null;
            }
        },

        methods: {
            get() {
                axios()
                    .get(this.url.data)
                    .then(response => {
                        _.set(this, 'item',
                            _.merge(this.item, response.data)
                        );
                    })
                    .run();
            }
        }
    };
</script>
