<template>
    <v-navigation-drawer
            v-model="drawer"
            app
            width="270"
    >
        <weather-component/>

        <v-divider/>

        <item-component :items="items"/>

    </v-navigation-drawer>
</template>

<script>
    import WeatherComponent from '../../plugins/weather';
    import ItemComponent from './_item';

    export default {
        components: {WeatherComponent, ItemComponent},

        computed: {
            drawer: {
                get() {
                    return this.$store.getters['main/drawler'];
                },
                set() {
                }
            },

            items() {
                let _items = this.$router.options.routes;

                return _.filter(_items, obj => /[^(\*|\/\d{0,3})]/.test(obj.path));
            }
        }
    };
</script>
