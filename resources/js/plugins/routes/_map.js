import _ from 'lodash';
import Item from './_item';

export default class map
{
    constructor(routes) {
        return _.map(routes, route => {
            let obj = route instanceof Item ? route.get() : route;

            if (! _.isUndefined(obj.children)) {
                let children = this.constructor(obj.children);

                _.set(obj, 'children', children);
            }

            return obj;
        });
    }
}
