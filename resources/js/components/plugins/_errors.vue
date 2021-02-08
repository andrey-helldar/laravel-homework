<template>
    <v-alert
        v-if="parsed"
        type="error"
        v-html="parsed"
    />
</template>
<script type="text/javascript">
import axios from '../../plugins/axios';

export default {
    props: ['errors'],

    computed: {
        parsed() {
            let _parsed = axios().__parse(this.errors);

            return _parsed?.message;
        }
    }
};
</script>
