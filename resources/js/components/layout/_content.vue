<template>
    <v-main>
        <v-layout fill-height justify-center>
            <v-container>
                <transition-view-component />
            </v-container>
        </v-layout>
    </v-main>
</template>

<script>
import TransitionViewComponent from './_transition-view';

export default {
    components: { TransitionViewComponent }
};
</script>
