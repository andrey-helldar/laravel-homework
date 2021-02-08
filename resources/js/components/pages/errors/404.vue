<template>
    <v-layout align-center justify-center>
        <error-component :value="message" />
    </v-layout>
</template>

<script type="text/javascript">
import ErrorComponent from './_layout';
import Lang from '../../../plugins/lang';

export default {
    components: { ErrorComponent },

    data() {
        return {
            message: Lang.get('errors.404')
        };
    }
};
</script>
