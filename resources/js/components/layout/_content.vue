<template>
    <v-content>
        <v-container
                fill-height
                fluid
        >
            <transition-view-component/>
        </v-container>
    </v-content>
</template>

<script>
    import TransitionViewComponent from './_transition-view';

    export default {
        components: {TransitionViewComponent}
    };
</script>
