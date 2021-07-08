const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    resolve: {
        fallback: {
            fs: require.resolve('browserify-fs'),
            path: require.resolve("path-browserify"),
            "crypto": require.resolve("crypto-browserify"),
            "https": require.resolve("https-browserify"),
            "http": require.resolve("stream-http"),
            "vm": require.resolve("vm-browserify"),
            "os": require.resolve("os-browserify/browser"),
            "stream": require.resolve("stream-browserify"),
            "constants": require.resolve("constants-browserify"),
        }
    }
})

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
