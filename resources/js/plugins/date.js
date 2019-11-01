import _ from 'lodash';

export default class
{
    static get(value = null) {
        return this.build(
            this.parse(value)
        );
    }

    static parse(value = null) {
        return _.isEmpty(value)
            ? new Date()
            : new Date(value);
    }

    static build(date) {
        let year = this.firstZero(date.getFullYear());
        let month = this.firstZero(date.getMonth());
        let day = this.firstZero(date.getDate());
        let hours = this.firstZero(date.getHours());
        let minutes = this.firstZero(date.getMinutes());

        return `${year}-${month}-${day} ${hours}:${minutes}`;
    }

    static firstZero(value = 0) {
        value = parseInt(value);

        return value < 10
            ? '0' + value
            : value;
    }
}
