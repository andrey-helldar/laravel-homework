<template>
    <v-app>
        <nav-component/>
        <header-component/>
        <content-component/>
        <footer-component/>

        <vue-snotify/>
    </v-app>
</template>

<script>
    import HeaderComponent from './_header';
    import ContentComponent from './_content';
    import FooterComponent from './_footer';
    import NavComponent from './_nav';

    export default {
        components: {HeaderComponent, ContentComponent, FooterComponent, NavComponent}
    };
</script>
