<template>
    <v-navigation-drawer
            v-model="drawer"
            app
    >
        <weather-component/>

        <v-divider/>

        <v-list
                dense
                nav
        >
            <v-list-item
                    link
            >
                <v-list-item-icon>
                    <v-icon>home</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>products</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item
                    link
            >
                <v-list-item-icon>
                    <v-icon>home</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>vendors</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import WeatherComponent from '../plugins/weather';

    export default {
        components: {WeatherComponent},

        computed: {
            drawer: {
                get() {
                    return this.$store.getters['main/drawler'];
                },
                set() {
                }
            }
        }
    };
</script>
