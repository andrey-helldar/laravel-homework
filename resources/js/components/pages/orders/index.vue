<template>
    <v-layout justify-center>

        <v-data-table
                :headers="headers"
                :items="items"
                :items-per-page-options="rowsPerPageItems"
                :search="search"
                item-key="title"
        >

        </v-data-table>

    </v-layout>
</template>
<script type="text/javascript">
    export default {
        data() {
            return {
                headers: [],
                items: [],
                search: null,

                rowsPerPageItems: [
                    10, 25, 50,
                    {'text': '$vuetify.dataIterator.rowsPerPageAll', 'value': -1}
                ]
            };
        },
        mounted() {
            //
        },
        methods: {
            //
        }
    };
</script>
