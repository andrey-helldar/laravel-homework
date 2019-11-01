<template>
    <v-footer
            app
            class="center-align"
            color="deep-purple"
            min-height="48"
    >
        <span class="white--text">{{ currentYear() }}</span>
    </v-footer>
</template>

<script>
    export default {
        methods: {
            currentYear() {
                let date = new Date;

                return date.getFullYear();
            }
        }
    };
</script>

<style scoped>
    .center-align {
        justify-content: center;
    }
</style>
