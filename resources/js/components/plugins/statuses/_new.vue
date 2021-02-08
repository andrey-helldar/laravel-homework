<template>
    <v-chip class="text-lowercase font-weight-light" color="green" dark small>
        <v-icon left>add</v-icon>
        {{ trans('orders.status.0') }}
    </v-chip>
</template>
<script type="text/javascript">
import Lang from '../../../plugins/lang';

export default {
    methods: {
        trans(key) {
            return Lang.get(key);
        }
    }
};
</script>
