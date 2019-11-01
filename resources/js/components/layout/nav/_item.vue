<template>
    <div v-cloak>
        <template
                v-for="item in items"
                v-if="isShow(item)"
        >
            <v-list-item
                    :to="{name: item.name}"
                    v-if="isEmpty(item.children)"
            >
                <v-list-item-icon v-if="isNotEmpty(item.meta.icon)">
                    <v-icon v-text="item.meta.icon"/>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title v-text="item.meta.title"/>
                </v-list-item-content>

            </v-list-item>

            <v-list-group
                    :prepend-icon="item.meta.icon"
                    no-action
                    v-else
            >
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.meta.title"/>
                    </v-list-item-content>
                </template>

                <template
                        v-for="child in item.children"
                        v-if="isShow(child)"
                >
                    <v-list-item
                            :to="{name: child.name}"
                            v-if="isEmpty(child.children)"
                    >
                        <v-list-item-content>
                            <v-list-item-title v-text="child.meta.title"/>
                        </v-list-item-content>

                        <v-list-item-icon v-if="isNotEmpty(child.meta.icon)">
                            <v-icon v-text="child.meta.icon"/>
                        </v-list-item-icon>
                    </v-list-item>

                    <v-list-group
                            no-action
                            sub-group
                            v-else
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title v-text="child.meta.title"/>
                            </v-list-item-content>
                        </template>

                        <v-list-item
                                :key="third.name"
                                :to="{name: third.name}"
                                v-for="third in child.children"
                                v-if="isShow(third)"
                        >
                            <v-list-item-content>
                                <v-list-item-title v-text="third.meta.title"/>
                            </v-list-item-content>
                        </v-list-item>

                    </v-list-group>

                </template>

            </v-list-group>
        </template>
    </div>
</template>
<script type="text/javascript">
    import _ from 'lodash';

    import Lang from '../../../plugins/lang/user';

    export default {
        props: ['items'],

        methods: {
            isShow(item) {
                return item.meta.hideInMenu !== true;
            },

            isEmpty(value) {
                return _.isEmpty(value) || _.isUndefined(value) || _.isNaN(value);
            },

            isNotEmpty(value) {
                return ! this.isEmpty(value);
            },

            trans(key) {
                return Lang.get(key);
            }
        }
    };
</script>
