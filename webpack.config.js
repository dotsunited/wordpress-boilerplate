const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');

module.exports = () => {
    const mode = 'production';
    const targetPath = 'public/app/themes/wordpress-boilerplate/assets';

    return {
        mode: mode,
        entry: {
            'load-css-polyfill': [
                '@dotsunited/load-css-polyfill/src/auto',
            ],
            'main-base': [
                './assets/main/base/index.css',
            ],
            'main-components': [
                './assets/webpack-public-path.js',
                '@babel/polyfill',
                './assets/main/components/index.js',
            ],
            'main-utilities': [
                './assets/main/utilities/index.css',
            ],
        },
        output: {
            path: path.resolve(__dirname, targetPath),
            //publicPath: '/app/themes/wordpress-boilerplate/assets/',
            filename: '[name].[contenthash].js',
            chunkFilename: '[name].[contenthash].js',
        },
        optimization: {
            runtimeChunk: 'single'
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
                                babelrc: false,
                                presets: [
                                    [
                                        '@babel/preset-env',
                                        {
                                            useBuiltIns: 'entry',
                                            modules: false,
                                            debug: true,
                                        }
                                    ]
                                ],
                                plugins: [
                                    '@babel/plugin-syntax-dynamic-import',
                                ]
                            },
                        },
                    ],
                },
                {
                    test: /\.css$/,
                    use: [
                        mode !== 'production' ? 'style-loader' : MiniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {
                                importLoaders: 1,
                                minimize: true,
                            }
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: [
                                    require('postcss-import')(),
                                    require('postcss-cssnext')(),
                                    require('postcss-flexbugs-fixes')()
                                ]
                            }
                        }
                    ],
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
            // https://webpack.js.org/guides/caching/#module-identifiers
            new webpack.HashedModuleIdsPlugin(),
            new MiniCssExtractPlugin({
                filename: '[name].[contenthash].css',
                chunkFilename: '[name].[contenthash].css',
            }),
            new ManifestPlugin(),
        ]
    };
};
