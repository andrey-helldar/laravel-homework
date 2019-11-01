import Lang from '../lang/user';

import Vue from 'vue';
import _ from 'lodash';


export default class Item
{
    name(value) {
        this._name = value;

        return this;
    }

    path(value) {
        this._path = value;

        return this;
    }

    redirect(name) {
        this._redirect = {name};

        return this;
    }

    component(path = null) {
        path = _.isNull(path) ? 'layout/_transition-view' : `pages/${path}`;

        let name = _.kebabCase(path);

        this._component = Vue.component(name, require(`../../components/${path}`).default);

        return this;
    }

    hideInMenu() {
        _.set(this, '_meta.hideInMenu', true);

        return this;
    }

    title(langKey) {
        let value = Lang.get(langKey);

        _.set(this, '_meta.title', value);

        return this;
    }

    icon(value) {
        _.set(this, '_meta.icon', _.trim(value));

        return this;
    }

    children(item) {
        if (_.isUndefined(this._children)) {
            this._children = [];
        }

        if (_.isArray(item)) {
            _.each(item, child => {
                this._children.push(child);
            });
        } else {
            this._children.push(item);
        }

        return this;
    }

    getRequired() {
        _.each(this, (value, key) => {
            if (_.startsWith(key, 'require')) {
                this[key]();
            }
        });
    }

    getParameters() {
        let obj = {};

        _.each(this, (value, key) => {
            if (_.startsWith(key, '_')) {
                let _key = key.substring(1);

                _.set(obj, _key, value);
            }
        });

        return obj;
    }

    get() {
        this.getRequired();

        return this.getParameters();
    }
}
