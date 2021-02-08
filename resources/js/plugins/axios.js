import _ from 'lodash';
import Lang from './lang';

const ax = require('axios');

ax.defaults.baseURL = '/api';

ax.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
ax.defaults.headers.common['Content-Type'] = 'application/json';
ax.defaults.headers.common['Access-Control-Allow-Methods'] = 'GET, POST, PUT, DELETE';
ax.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
ax.defaults.headers.common['Access-Control-Allow-Headers'] = '*';


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    ax.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found!');
}

class AxiosService
{
    _availableMethods = ['GET', 'POST', 'PUT', 'DELETE'];

    _availableMessages = {
        'GET': { loading: 'statuses.loading', loaded: 'statuses.loaded' },
        'POST': { loading: 'statuses.creature', loaded: 'statuses.created' },
        'PUT': { loading: 'statuses.updating', loaded: 'statuses.updated' },
        'DELETE': { loading: 'statuses.deleting', loaded: 'statuses.deleted' }
    };

    _method = 'GET';
    _options = {};
    _data = {};

    _loadingMessage = null;
    _loadedMessage = null;

    _beforeRun = null;
    _then = null;
    _catch = null;
    _finally = null;

    method(value) {
        if (_.indexOf(this._availableMethods, _.toUpper(value)) === -1) {
            throw `Unknown method "${ value }"!`;
        }

        this._method = value;

        return this;
    }

    url(value) {
        this._url = value;

        return this;
    }

    get(url) {
        this.method('GET');
        this.url(url);

        return this;
    }

    post(url, data = {}) {
        this.method('POST');
        this.url(url);
        this.data(data);

        return this;
    }

    put(url, data = {}) {
        this.method('PUT');
        this.url(url);
        this.data(data);

        return this;
    }

    delete(url) {
        this.method('DELETE');
        this.url(url);

        return this;
    }

    data(data) {
        this._data = data;

        return this;
    }

    options(values) {
        this._options = values;

        return this;
    }

    then(callback) {
        this._then = callback;

        return this;
    }

    catch(callback) {
        this._catch = callback;

        return this;
    }

    beforeRun(callback) {
        this._beforeRun = callback;

        return this;
    }

    finally(callback) {
        this._finally = callback;

        return this;
    }

    loadingMessage(value = null) {
        this._loadingMessage = value;

        return this;
    }

    loadedMessage(value = null) {
        this._loadedMessage = value;

        return this;
    }

    messages(loading = null, loaded = null) {
        this.loadingMessage(loading);
        this.loadedMessage(loaded);

        return this;
    }

    run() {
        this.__checkMessages();
        this.__runIfNotEmpty(this._beforeRun);
        this.__runWhenSnotifyLoaded();
    }

    baseURL() {
        return ax.defaults.baseURL;
    }

    csrf() {
        return ax.defaults.headers.common['X-CSRF-TOKEN'];
    }

    async __runWhenSnotifyLoaded() {
        while (typeof window?.vm?.$snotify === 'undefined') {
            await this.__sleep(100);
        }

        this.__async();
    }

    __sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    __async() {
        window.vm.$snotify.async(this._loadingMessage, '', () => new Promise((resolve, reject) => {
            const method = _.toLower(this._method);
            const config = {
                closeOnClick: true,
                pauseOnHover: true,
                showProgressBar: true,
                timeout: 10000
            };

            const notify = {
                title: '',
                config
            };

            ax[method](this._url, this._data, this._options)
                .then(response => {
                    this.__runIfNotEmpty(this._then, response);

                    resolve(_.merge(notify, {
                        html: this._loadedMessage,
                        config: _.merge(config, { timeout: 1000 })
                    }));
                })
                .catch(error => {
                    this.__runIfNotEmpty(this._catch, error);

                    reject(_.merge(notify, {
                        html: this.__parse(error).message
                    }));
                })
                .finally(() => {
                    this.__runIfNotEmpty(this._finally);
                });
        }));
    }

    __runIfNotEmpty(_callback = null, attributes = {}) {
        if (! _.isNull(_callback)) {
            _callback(attributes);
        }
    }

    __checkMessages() {
        this._loadingMessage = this._loadingMessage
            ? Lang.get(this._loadingMessage)
            : Lang.get(_.get(this._availableMessages, `${ this._method }.loading`));

        this._loadedMessage = this._loadedMessage
            ? Lang.get(this._loadedMessage)
            : Lang.get(_.get(this._availableMessages, `${ this._method }.loaded`));
    }

    __parse(message, type = 'info') {
        try {
            message =
                message?.response?.data?.error?.msg ? message?.response?.data?.error?.msg
                    : message?.response?.data?.errors ? message?.response?.data?.errors
                    : message?.data ? message?.data
                        : message?.message ? message?.message : null;

            if (_.isArray(message)) {
                message = _.flattenDeep(message).join('<br>');
            } else if (_.isObject(message)) {
                message = _.flatMapDeep(message).join('<br>');
            }
        } catch (e) {
            message = e.message;
            type = 'error';
        }

        return { message, type };
    }
}

export default () => {
    return new AxiosService();
}
