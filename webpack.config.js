var path = require("path");
var webpack = require("webpack");
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var autoprefixer = require('autoprefixer-core');

module.exports = {
    entry: {
        main: [/*"./assets/webpack-public-path", */"./assets/main"],
        'main-critical-css': [/*"./assets/webpack-public-path", */"./assets/main/index-critical-css"],
        ie8:  [/*"./assets/webpack-public-path", */"./assets/ie8"]
    },
    output: {
        path: path.join(__dirname, "web/wp-content/themes/wordpress-boilerplate/assets/scripts"),
        publicPath: "/wp-content/themes/wordpress-boilerplate/assets/scripts/",
        filename: "[name].js", // append ?[hash] to fix entry chunks not updated correctly
        chunkFilename: "[name].[chunkhash].js"
    },
    module: {
        loaders: [
            { test: /\.less$/, loader: ExtractTextPlugin.extract("style-loader", "css-loader!postcss-loader!less-loader") },
            { test: /\.css$/,  loader: ExtractTextPlugin.extract("style-loader", "css-loader!postcss-loader") },

            { test: /\.(gif|png|jpe?g)$/, loader: "file-loader?name=static/[hash].[ext]!image-webpack" },

            { test: /\.woff(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "url-loader?name=static/[hash].[ext]&limit=1&mimetype=application/font-woff" },
            { test: /\.(ttf|eot|svg|woff2)(\?.+)?$/, loader: "file-loader?name=static/[hash].[ext]" },

            { test: /\.(swf)$/, loader: "file-loader?name=static/[hash].[ext]" },

            // required for modernizr and respond.js, see https://github.com/webpack/webpack/issues/512
            { test: /modernizr\.js$/, loader: "imports?this=>window!exports?window.Modernizr" },
            { test: /respond\.js$/, loader: "imports?this=>window" }
        ]
    },
    postcss: [
        autoprefixer({
            browsers: [
                "Android 2.3",
                "Android >= 4",
                "Chrome >= 20",
                "Firefox >= 24",
                "Explorer >= 8",
                "iOS >= 6",
                "Opera >= 12",
                "Safari >= 6"
            ]
        })
    ],
    plugins: [
        new webpack.ProvidePlugin({
            // Automtically detect jQuery and $ as free var in modules
            // and inject the jquery library
            // This is required by many jquery plugins
            jQuery: "jquery",
            $: "jquery"
        }),
        new webpack.DefinePlugin({
            'process.env': {
                // This has effect on the react lib size
                'NODE_ENV': JSON.stringify('production')
            }
        }),
        new webpack.optimize.DedupePlugin(),
        new webpack.optimize.UglifyJsPlugin({
            output: {
                comments: false
            }
        }),
        new webpack.NoErrorsPlugin(),

        new ExtractTextPlugin("[name].css", {
            allChunks: false
        })
    ]
};
