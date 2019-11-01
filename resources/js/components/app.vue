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
    import HeaderComponent from './layout/_header';
    import ContentComponent from './layout/_content';
    import FooterComponent from './layout/_footer';
    import NavComponent from './layout/nav/_index';

    export default {
        components: {HeaderComponent, ContentComponent, FooterComponent, NavComponent}
    };
</script>
