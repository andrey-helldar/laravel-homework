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
                return "foo";
            }
        },

        methods: {
            lang(key)
            {

            }
        }
    };
</script>
