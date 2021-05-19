const mix = require('laravel-mix');

const assets = './resources/';

mix
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /resources[\\\/]lang.+\.php$/,
                    loader: 'laravel-localization-loader'
                }
            ]
        }
    })

    .js(assets + 'js/app.js', 'public/js')
    .vue()
    .extract()

    .copy(assets + 'images/robot.png', 'public/images')

    .version()
    .sourceMaps()

    .browserSync({
        proxy: 'localhost',
        port: 3000
    });
