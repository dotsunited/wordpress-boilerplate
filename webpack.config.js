var path = require('path');
var webpack = require('webpack');
var ExtractTextPlugin = require('extract-text-webpack-plugin');

// PostCSS plugins
var cssnext = require('postcss-cssnext');
var postcssFocus = require('postcss-focus');
var postcssReporter = require('postcss-reporter');

module.exports = {
    target: 'web',
    progress: true,
    entry: {
        main: ['./assets/webpack-public-path', './assets/main'],
        'main-critical': ['./assets/webpack-public-path', './assets/main/index-critical']
    },
    output: {
        path: path.join(__dirname, 'web/wp-content/themes/wordpress-boilerplate/assets/scripts'),
        publicPath: '/wp-content/themes/wordpress-boilerplate/assets/scripts/',
        filename: '[name].js', // append ?[hash] to fix entry chunks not updated correctly
        chunkFilename: '[name].[chunkhash].js'
    },
    module: {
        loaders: [
            {
                test: /\.less$/,
                exclude: /node_modules/,
                loader: ExtractTextPlugin.extract(
                    'style',
                    'css!postcss!less'
                )
            },
            {
                test: /\.css$/,
                exclude: /node_modules/,
                loader: ExtractTextPlugin.extract(
                    'style',
                    'css!postcss'
                )
            },
            {
                test: /\.less$/,
                include: /node_modules/,
                loaders: ['style', 'css', 'less']
            },
            {
                test: /\.css$/,
                include: /node_modules/,
                loaders: ['style', 'css']
            },

            {
                test: /\.(gif|png|jpe?g|svg)(\?.+)?$/,
                loaders: [
                    'file?name=static/[hash].[ext]',
                    'image-webpack?{progressive:true, optimizationLevel: 7, interlaced: false, pngquant:{quality: "65-90", speed: 4}}'
                ]
            },

            {
                test: /\.(eot|ttf|woff|woff2)(\?.+)?$/,
                loaders: ['file?name=static/[hash].[ext]']
            },

            {
                test: /\.(swf|xap)$/,
                loaders: ['file?name=static/[hash].[ext]']
            },

            // required for modernizr, see https://github.com/webpack/webpack/issues/512
            {
                test: /modernizr\.js$/,
                loaders: ['imports?this=>window', 'exports?window.Modernizr']
            },
            {
                test: /cssrelpreload\.js$/,
                loaders: ['imports?this=>window']
            }
        ]
    },
    postcss: [
        postcssFocus(),
        cssnext(),
        postcssReporter({
            clearMessages: true
        })
    ],
    plugins: [
        new webpack.ProvidePlugin({
            // Automtically detect jQuery and $ as free var in modules
            // and inject the jquery library
            // This is required by many jquery plugins
            jQuery: 'jquery',
            $: 'jquery'
        }),
        new webpack.DefinePlugin({
            'process.env': {
                'NODE_ENV': JSON.stringify('production')
            }
        }),
        // OccurrenceOrderPlugin is needed for long-term caching to work properly.
        // See http://mxs.is/googmv
        new webpack.optimize.OccurrenceOrderPlugin(true),
        new webpack.optimize.DedupePlugin(),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false
            },
            output: {
                comments: false
            }
        }),
        new webpack.NoErrorsPlugin(),

        new ExtractTextPlugin('[name].css')
    ]
};
