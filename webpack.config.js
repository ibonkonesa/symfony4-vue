const { VueLoaderPlugin } = require('vue-loader');
let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .addEntry('app', './assets/js/app.js')
    .enableSassLoader(function (sassOptions) {
    }, {
        resolveUrlLoader: false,
    })
    .enableVueLoader()
    .addPlugin(new VueLoaderPlugin());

module.exports = Encore.getWebpackConfig();
