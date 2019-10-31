import _ from 'lodash';

import './snotify';

export default class Notify
{
    static info(vue, message) {
        this.show(vue, message, 'info');
    }

    static success(vue, message) {
        this.show(vue, message, 'success');
    }

    static error(vue, message) {
        this.show(vue, message, 'error');
    }

    static show(vue, message, type = 'info') {
        let parsed = this.parse(message, type);

        vue.$snotify[parsed.type](parsed.message);
    }

    static get(obj, key) {
        let value = _.get(obj, key);

        return _.isUndefined(value) ? null : value;
    }

    static parse(message, type = 'info') {
        try {
            let value;

            if ((value = this.get(message, 'response.data.error.msg'))) {
                message = value;
            }
            else if ((value = this.get(message, 'data'))) {
                message = value;
            }
            else if ((value = this.get(message, 'message'))) {
                message = value;
            }

            if (_.isArray(message)) {
                message = _.flattenDeep(message).join('<br>');
            }
            else if (_.isObject(message)) {
                message = _.flatMapDeep(message).join('<br>');
            }
        }
        catch (e) {
            message = e.message;
            type = 'error';
        }

        return {message, type};
    }
}
