<template>
    <v-alert
            type="error"
            v-if="parsed.length"
            v-html="parsed"
    />
</template>
<script type="text/javascript">
    export default {
        props: ['errors'],

        computed: {
            parsed() {
                return [];
            }
        }
    };
</script>
