import {ICON_APARTMENT, ICON_ASSIGNMENT, ICON_DASHBOARD, ICON_GROUP, ICON_SHOPPING_CART} from '../constants/_icons';

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
        .icon(ICON_ASSIGNMENT)
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

    (new Item)
        .path('/partners')
        .component()
        .icon(ICON_GROUP)
        .title('titles.partners')
        .children(
            [
                (new Item)
                    .name('partners.index').path('index')
                    .component('partners/index')
                    .title('buttons.showAll'),

                (new Item)
                    .name('partners.create').path('create')
                    .component('partners/create')
                    .title('buttons.create'),

                (new Item)
                    .name('partners.edit').path(':id/edit')
                    .component('partners/edit')
                    .hideInMenu()
            ]
        ),

    (new Item)
        .path('/products')
        .component()
        .icon(ICON_SHOPPING_CART)
        .title('titles.products')
        .children(
            [
                (new Item)
                    .name('products.index').path('index')
                    .component('products/index')
                    .title('buttons.showAll'),

                (new Item)
                    .name('products.create').path('create')
                    .component('products/create')
                    .title('buttons.create'),

                (new Item)
                    .name('products.edit').path(':id/edit')
                    .component('products/edit')
                    .hideInMenu()
            ]
        ),

    (new Item)
        .path('/vendors')
        .component()
        .icon(ICON_APARTMENT)
        .title('titles.vendors')
        .children(
            [
                (new Item)
                    .name('vendors.index').path('index')
                    .component('vendors/index')
                    .title('buttons.showAll'),

                (new Item)
                    .name('vendors.create').path('create')
                    .component('vendors/create')
                    .title('buttons.create'),

                (new Item)
                    .name('vendors.edit').path(':id/edit')
                    .component('vendors/edit')
                    .hideInMenu()
            ]
        ),

    (new Item).name('404').path('/404').component('errors/404')

];

export default new map(routes);
