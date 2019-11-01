<template>
    <v-app-bar
            app
            dark
            color="indigo"
    >
        <v-toolbar-title v-text="title"/>
    </v-app-bar>
</template>

<script>
    export default {

        computed: {
            title()
            {
                return this.$store.getters["main/pageTitle"];
            },

            drawer: {
                get()
                {
                    return this.$store.getters["main/drawler"];
                },

                set(value)
                {
                    this.$store.commit("main/drawler", value);
                }
            }
        }
    };
</script>
