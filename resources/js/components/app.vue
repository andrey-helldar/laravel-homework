<template>
    <v-app>
        <header-component/>
        <content-component/>
        <footer-component/>
    </v-app>
</template>

<script>
    import HeaderComponent from "./layout/_header";
    import ContentComponent from "./layout/_content";
    import FooterComponent from "./layout/_footer";

    export default {
        components: {HeaderComponent, ContentComponent, FooterComponent}
    };
</script>
