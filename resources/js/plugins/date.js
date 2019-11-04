import _ from 'lodash';

export default class
{
    static get(value = null) {
        let ___parsed = this.__parse(value);
        let _date = this.__buildDate(___parsed);
        let _time = this.__buildTime(___parsed);

        return `${_date} ${_time}`;
    }

    static getDate(value = null) {
        return this.__buildDate(
            this.__parse(value)
        );
    }

    static getTime(value = null) {
        return this.__buildTime(
            this.__parse(value)
        );
    }

    static __parse(value = null) {
        return value instanceof Date
            ? value
            : _.isEmpty(value)
                ? new Date()
                : new Date(value);
    }

    static __buildDate(date) {
        let year = this.__firstZero(date.getFullYear());
        let month = this.__firstZero(date.getMonth() + 1);
        let day = this.__firstZero(date.getDate());

        return `${year}-${month}-${day}`;
    }

    static __buildTime(date) {
        let hours = this.__firstZero(date.getHours());
        let minutes = this.__firstZero(date.getMinutes());

        return `${hours}:${minutes}`;
    }

    static __firstZero(value = 0) {
        value = _.isInteger(value) ? value : parseInt(value);

        return value < 10
            ? '0' + value
            : value;
    }
}
