const mix = require('laravel-mix');
const path = require('path');
const glob = require('glob-all');

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

    .options({
        purifyCss: {
            moduleExtensions: ['php', 'vue', 'js'],
            paths: glob.sync([
                path.join(__dirname, 'resources/**/*.blade.php'),
                path.join(__dirname, 'resources/**/*.vue'),
                path.join(__dirname, 'resources/**/*.js')
            ]),
            purifyOptions: {
                whitelist: [],
                rejected: true
            }
        }
    })

    .sass(assets + 'sass/app.scss', 'public/css')

    .js(assets + 'js/app.js', 'public/js')
    .extract()

    .version()
    .sourceMaps()

    .browserSync({
        proxy: 'localhost',
        port: 3000
    });
