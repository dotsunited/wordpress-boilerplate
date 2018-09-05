const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const PostCSSAssetsPlugin = require('postcss-assets-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');

module.exports = () => {
    const mode = 'production';
    const targetPath = 'public/app/themes/wordpress-boilerplate/assets';

    return {
        mode: mode,
        entry: {
            'main': [
                './assets/webpack-public-path.js',
                './assets/main/index.js',
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
        resolve: {
            // Extends the default config by adding the .css extension
            // to allow index.css entry points.
            // See https://webpack.js.org/configuration/resolve/#resolve-extensions
            extensions: ['.wasm', '.mjs', '.js', '.json', '.css'],
            // Extends the default config by adding the es2015 field
            // and removes the browser fields.
            // See https://webpack.js.org/configuration/resolve/#resolve-mainfields
            mainFields: ['es2015', 'module', 'main']
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
                                minimize: false, // Minification done by the PostCSSAssetsPlugin
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
                                disable: mode !== 'production',
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
            new PostCSSAssetsPlugin({
                plugins: [
                    require('cssnano')({
                        preset: ['default', {
                            discardComments: {
                                removeAll: true,
                            },
                        }]
                    }),
                ],
            }),
            new ManifestPlugin(),
        ]
    };
};
