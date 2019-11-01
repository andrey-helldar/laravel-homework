<template>
    <v-container fill-height fluid>
        <v-layout align-center justify-center>
            <h1 class="display-1" v-text="value"/>
        </v-layout>
    </v-container>
</template>
<script type="text/javascript">
    export default {
        props: ['value'],

        beforeMount() {
            this.setPageTitle();
        },

        methods: {
            setPageTitle() {
                this.$store.commit('main/pageTitle', this.value);
            }
        }
    };
</script>
