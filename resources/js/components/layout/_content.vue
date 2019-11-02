<template>
    <v-content>
        <v-layout justify-center fill-height>
            <v-container>
                <transition-view-component/>
            </v-container>
        </v-layout>
    </v-content>
</template>

<script>
    import TransitionViewComponent from './_transition-view';

    export default {
        components: {TransitionViewComponent}
    };
</script>
