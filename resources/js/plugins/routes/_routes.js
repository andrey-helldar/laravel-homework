import {ICON_DASHBOARD, ICON_PAGES} from '../constants/_icons';

import Item from './_item';
import map from './_map';

let routes = [
    (new Item).path('*').redirect('404'),
    (new Item).path('/').redirect('dashboard'),

    (new Item).name('dashboard').path('/dashboard')
        .component('dashboard')
        .icon(ICON_DASHBOARD)
        .title('titles.dashboard'),

    (new Item)
        .path('/orders')
        .component()
        .icon(ICON_PAGES)
        .title('titles.orders')
        .children(
            [
                (new Item)
                    .name('orders.index').path('index')
                    .component('orders/index')
                    .title('buttons.showAll'),

                (new Item)
                    .name('orders.create').path('create')
                    .component('orders/create')
                    .title('buttons.create'),

                (new Item)
                    .name('orders.edit').path(':id/edit')
                    .component('orders/edit')
                    .hideInMenu()
            ]
        ),

    (new Item).name('404').path('/404').component('errors/404')

];

export default new map(routes);
