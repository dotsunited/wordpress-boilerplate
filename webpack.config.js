var path = require("path");
var webpack = require("webpack");
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var autoprefixer = require('autoprefixer');

module.exports = {
    entry: {
        main: ["./assets/webpack-public-path", "./assets/main"],
        'main-critical': ["./assets/webpack-public-path", "./assets/main/index-critical"]
    },
    output: {
        path: path.join(__dirname, "web/wp-content/themes/wordpress-boilerplate/assets/scripts"),
        //publicPath: "/wp-content/themes/wordpress-boilerplate/assets/scripts/",
        filename: "[name].js", // append ?[hash] to fix entry chunks not updated correctly
        chunkFilename: "[name].[chunkhash].js"
    },
    module: {
        loaders: [
            { test: /\.less$/, loader: ExtractTextPlugin.extract("style", "css!postcss!less") },
            { test: /\.css$/,  loader: ExtractTextPlugin.extract("style", "css!postcss") },

            { test: /\.(gif|png|jpe?g|svg)(\?.+)?$/, loader: "file?name=static/[hash].[ext]!image-webpack" },

            { test: /\.(woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "file?name=static/[hash].[ext]&mimetype=application/font-woff" },
            { test: /\.(ttf|eot)(\?.+)?$/, loader: "file?name=static/[hash].[ext]" },

            { test: /\.(swf|xap)$/, loader: "file?name=static/[hash].[ext]" },

            // required for modernizr, see https://github.com/webpack/webpack/issues/512
            { test: /modernizr\.js$/, loader: "imports?this=>window!exports?window.Modernizr" }
        ]
    },
    postcss: [
        autoprefixer({
            browsers: ['last 2 versions', 'IE >= 9']
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

        new ExtractTextPlugin("[name].css")
    ]
};
