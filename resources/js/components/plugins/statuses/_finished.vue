<template>
    <v-chip class="text-lowercase font-weight-light" small>
        <v-icon left>done</v-icon>
        {{ trans('orders.status.20') }}
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
