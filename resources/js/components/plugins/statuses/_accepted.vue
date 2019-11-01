<template>
    <v-chip small dark color="blue" class="text-lowercase font-weight-light">
        <v-icon left>done</v-icon>
        {{ trans('orders.status.10') }}
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
