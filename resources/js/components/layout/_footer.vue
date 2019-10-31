<template>
    <v-footer
            app
            color="indigo"
    >
        <span class="white--text">© {{ currentYear() }}</span>
    </v-footer>
</template>

<script>
    export default {
        methods: {
            currentYear()
            {
                let date = new Date;

                return date.getFullYear();
            }
        }
    };
</script>
