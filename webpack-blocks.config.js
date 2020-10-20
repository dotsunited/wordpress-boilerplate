const path = require('path');
const webpack = require('webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, argv) => {
    const mode = argv.mode === 'development' ? 'development' : 'production';
    const targetPath = 'public/wp-content/mu-plugins/wordpress-boilerplate/modules/gutenberg/blocks/assets';

    return {
        mode: mode,
        bail: true,
        entry: {
            'blocks': [
                './assets/polyfills.js',
                './assets/gutenberg/index.js'
            ]
        },
        output: {
            path: path.resolve(__dirname, targetPath),
            publicPath: '/public/wp-content/mu-plugins/wordpress-boilerplate/modules/gutenberg/blocks/assets/',
            filename: '[name].js',
            chunkFilename: '[name].js',
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: [
                        {
                            loader: 'babel-loader',
                            options: {
                                presets: [
                                    [
                                        '@babel/preset-env',
                                        {
                                            modules: false,
                                        }
                                    ]
                                ],
                                plugins: [
                                    ['@babel/plugin-transform-react-jsx', {
                                        'pragma': 'wp.element.createElement'
                                    }]
                                ]
                            },
                        },
                    ],
                },
                {
                    test: /\.css$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {
                                importLoaders: 1,
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    plugins: [
                                        require('postcss-import')(),
                                        require('postcss-flexbugs-fixes')(),
                                        require('postcss-preset-env')({
                                            stage: 0,
                                            autoprefixer: {
                                                flexbox: 'no-2009',
                                                grid: true,
                                            },
                                            features: {
                                                'custom-properties': {
                                                    preserve: false
                                                }
                                            }
                                        }),
                                    ]
                                }
                            }
                        }
                    ],
                },
            ],
        },
        plugins: [
            new CleanWebpackPlugin(),
            // https://webpack.js.org/guides/caching/#module-identifiers
            new MiniCssExtractPlugin({
                filename: '[name].css',
                chunkFilename: '[name].css',
            }),
        ]
    };
};
