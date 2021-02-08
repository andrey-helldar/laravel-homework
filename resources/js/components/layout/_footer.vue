<template>
    <v-footer
        app
        class="white--text justify-center"
        color="deep-purple"
        min-height="48"
    >
        {{ currentYear() }} © {{ title }}
    </v-footer>
</template>

<script>
export default {
    computed: {
        title() {
            return this.$store.getters['main/pageTitle'];
        }
    },

    methods: {
        currentYear() {
            let date = new Date;

            return date.getFullYear();
        }
    }
};
</script>
