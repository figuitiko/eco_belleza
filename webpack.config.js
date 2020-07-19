var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('sb-admin-css', './assets/css/sb-admin-2.min.css')
    .addStyleEntry('owl_carousel_css', './assets/css/owl.carousel.css')
    .addStyleEntry('style_css', './assets/css/style.css')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    .addEntry('sb-admin', './assets/js/sb-admin-2.min.js')
    //.addEntry('dataTable-bootstrap', './assets/js/dataTables.bootstrap4.min.js')
    .addEntry('datatable_demo', './assets/js/datatables-demo.js')
    .addEntry('main_js', './assets/js/front/main.js')
    .addEntry('mixitup_js', './assets/js/front/mixitup.min.js')
    .addEntry('owl_carousel_min_js', './assets/js/front/owl.carousel.min.js')
    .addEntry('circle_progress_min_js', './assets/js/front/circle-progress.min.js')



    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    .copyFiles({
        from: './assets/img',
        to: 'images/[path] [name].[hash:8].[ext]'

    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    //.enableSassLoader()
    .enableVueLoader(()=>{},{
        useJsx:true
    }, { runtimeCompilerBuild: false })

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
