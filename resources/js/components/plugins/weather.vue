<template>
    <span @click="get">
        qwe
    </span>
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
