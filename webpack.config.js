const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');

module.exports = (env) => {
    const isDev = env === 'development';
    const targetPath = 'public/app/themes/wordpress-boilerplate/assets';

    const config = {
        entry: {
            'main-base': [
                './assets/main/base/index.css',
            ],
            'main-components-critical': [
                './assets/webpack-public-path.js',
                './assets/main/components/index-critical.js',
            ],
            'main-components': [
                './assets/webpack-public-path.js',
                './assets/main/components/index.js',
            ],
            'main-utilities': [
                './assets/main/utilities/index.css',
            ],
        },
        output: {
            path: path.resolve(__dirname, targetPath),
            //publicPath: '/app/themes/wordpress-boilerplate/assets/',
            filename: '[name].[chunkhash].js',
            chunkFilename: '[name].[chunkhash].js',
        },
        module: {
            strictExportPresence: true,
            rules: [
                {
                    test: /\.js$/,
                    use: [
                        {
                            loader: 'babel-loader',
                            options: {
                                cacheDirectory: true,
                            },
                        },
                    ],
                },
                {
                    test: /\.css$/,
                    use: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: [
                            {
                                loader: 'css-loader',
                                options: {
                                    importLoaders: 1,
                                    minimize: true,
                                }
                            },
                            'postcss-loader',
                        ],
                    }),
                },
                {
                    test: /\.(gif|png|jpe?g|svg)$/i,
                    use: [
                        'file-loader',
                        {
                            loader: 'image-webpack-loader',
                            options: {
                                bypassOnDebug: true,
                            },
                        },
                    ],
                },
                {
                    test: /\.(woff|woff2|eot|ttf|otf)$/,
                    use: [
                        'file-loader',
                    ],
                },
            ],
        },
        plugins: [
            new CleanWebpackPlugin([targetPath + '/*']),
            new webpack.DefinePlugin({
                'process.env': {
                    'NODE_ENV': isDev ? 'development' : 'production'
                }
            }),
            new webpack.HashedModuleIdsPlugin(),
            new webpack.optimize.UglifyJsPlugin({
                compress: {
                    warnings: false,
                },
                output: {
                    comments: false,
                },
            }),
            new ExtractTextPlugin('[name].[chunkhash].css'),
            new ManifestPlugin(),
        ]
    };

    return config;
};
