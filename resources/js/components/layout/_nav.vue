<template>
    <v-navigation-drawer
            v-model="drawer"
            app
    >
        <v-list dense>
            <v-list-item @click="">
                <v-list-item-action>
                    <v-icon>home</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Home</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="">
                <v-list-item-action>
                    <v-icon>contact_mail</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Contact</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import axios from "../../plugins/axios";

    export default {
        data()
        {
            return {
                url: "/weather",

                item: {}
            };
        },

        mounted()
        {
            this.get();
        },

        computed: {
            drawer()
            {
                return this.$store.getters["main/drawler"];
            }
        },

        methods: {
            get()
            {
                axios()
                        .get(this.url)
                        .then(response => this.item = response)
                        .run();
            }
        }
    };
</script>
