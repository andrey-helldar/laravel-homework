function load(path) {
    return require(`../../../lang/${path}`);
}

export default {
    'en.buttons': load('en/buttons.php'),
    'ru.buttons': load('ru/buttons.php'),

    'en.forms': load('en/forms.php'),
    'ru.forms': load('ru/forms.php'),

    'en.pagination': load('en/pagination.php'),
    'ru.pagination': load('ru/pagination.php'),

    'en.statuses': load('en/statuses.php'),
    'ru.statuses': load('ru/statuses.php'),

    'en.titles': load('en/titles.php'),
    'ru.titles': load('ru/titles.php'),

    'en.errors': load('en/errors.php'),
    'ru.errors': load('ru/errors.php'),

    'en.orders': load('en/orders.php'),
    'ru.orders': load('ru/orders.php'),

    'en.info': load('en/info.php'),
    'ru.info': load('ru/info.php')
};
