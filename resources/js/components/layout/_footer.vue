<template>
    <v-footer
            app
            color="indigo"
            min-height="48"
            class="center-align"
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
