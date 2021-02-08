<template>
    <div v-cloak>
        <template
            v-for="item in items"
            v-if="isShow(item)"
        >
            <v-list-item
                v-if="isEmpty(item.children)"
                :to="{name: item.name}"
            >
                <v-list-item-icon v-if="isNotEmpty(item.meta.icon)">
                    <v-icon v-text="item.meta.icon" />
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title v-text="item.meta.title" />
                </v-list-item-content>

            </v-list-item>

            <v-list-group
                v-else
                :prepend-icon="item.meta.icon"
                no-action
            >
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.meta.title" />
                    </v-list-item-content>
                </template>

                <template
                    v-for="child in item.children"
                    v-if="isShow(child)"
                >
                    <v-list-item
                        v-if="isEmpty(child.children)"
                        :to="{name: child.name}"
                    >
                        <v-list-item-content>
                            <v-list-item-title v-text="child.meta.title" />
                        </v-list-item-content>

                        <v-list-item-icon v-if="isNotEmpty(child.meta.icon)">
                            <v-icon v-text="child.meta.icon" />
                        </v-list-item-icon>
                    </v-list-item>

                    <v-list-group
                        v-else
                        no-action
                        sub-group
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title v-text="child.meta.title" />
                            </v-list-item-content>
                        </template>

                        <v-list-item
                            v-for="third in child.children"
                            v-if="isShow(third)"
                            :key="third.name"
                            :to="{name: third.name}"
                        >
                            <v-list-item-content>
                                <v-list-item-title v-text="third.meta.title" />
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

import Lang from '../../../plugins/lang';

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
