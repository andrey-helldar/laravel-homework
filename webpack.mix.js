const mix = require('laravel-mix');

const assets = './resources/';

mix
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /resources[\\\/]lang.+\.(php|json)$/,
                    loader: 'laravel-localization-loader'
                }
            ]
        }
    })

    .js(assets + 'js/app.js', 'public/js')
    .extract()

    .version()
    .sourceMaps()

    .browserSync({
        proxy: 'localhost',
        port: 3000
    });
