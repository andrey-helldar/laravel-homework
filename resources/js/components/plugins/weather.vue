<template>
    <v-list-item>
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
                url: '/weather',

                item: {
                    fact: {
                        season: '---',
                        temp: '---'
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
            }
        },

        methods: {
            get() {
                axios()
                    .get(this.url)
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
