const path = require('path');
const webpack = require('webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const glob = require('glob');

function getAppJsExcludeRegexp() {
    return new RegExp('node_modules\/(?!domestique|ctrly)');
}

// Custom PurgeCSS extractor for Tailwind that allows special characters in
// class names.
// https://www.purgecss.com/extractors
class TailwindPurgecssExtractor {
    static extract(content) {
        return content.match(/[A-Za-z0-9-_:\/]+/g) || [];
    }
}

function getStyleLoaders() {
    return [
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
                        require('postcss-focus-within')(),
                        require('postcss-preset-env')({
                            stage: 0,
                            autoprefixer: {
                                flexbox: 'no-2009',
                                grid: true,
                            },
                            features: {
                                'custom-properties': {
                                    preserve: false
                                },
                                'focus-within-pseudo-class': false,
                            }
                        }),
                    ]
                }
            }
        },
    ];
}

module.exports = (env, argv) => {
    const mode = argv.mode === 'development' ? 'development' : 'production';
    const targetPath = 'public/wp-content/themes/wordpress-boilerplate/assets';

    return {
        mode: mode,
        entry: {
            'main': [
                './assets/webpack-public-path.js',
                './assets/polyfills.js',
                './assets/main/index.js',
            ],
            'icons': [
                './assets/icons/index.css',
                './assets/icons/symbol-defs.svg',
            ]
        },
        output: {
            path: path.resolve(__dirname, targetPath),
            publicPath: '',
            filename: '[name].[contenthash].js',
            chunkFilename: '[name].[contenthash].js',
        },
        optimization: {
            minimizer: [
                new TerserPlugin({
                    terserOptions: {
                        output: {
                            comments: false,
                        },
                    },
                    parallel: true,
                }),
                new CssMinimizerPlugin({
                    parallel: true,
                    minimizerOptions: {
                        preset: ['default', {
                            discardComments: {
                                removeAll: true,
                            },
                        }],
                    },
                }),
            ],
            runtimeChunk: 'single',
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
                    oneOf: [
                        {
                            test: /\.(js|mjs)$/,
                            exclude: getAppJsExcludeRegexp(),
                            use: [
                                {
                                    loader: 'babel-loader',
                                    options: {
                                        babelrc: false,
                                        configFile: false,
                                        compact: true,
                                        highlightCode: true,
                                        presets: [
                                            [
                                                '@babel/preset-env',
                                                {
                                                    useBuiltIns: 'entry',
                                                    corejs: "3.0.0",
                                                    modules: false,
                                                    targets: {
                                                        ie: "11"
                                                    }
                                                }
                                            ]
                                        ],
                                        plugins: [
                                            '@babel/plugin-syntax-dynamic-import',
                                        ]
                                    },
                                },
                                {
                                    loader: 'eslint-loader'
                                },
                            ],
                        },
                        {
                            test: /\.(js|mjs)$/,
                            use: [
                                {
                                    loader: 'babel-loader',
                                    options: {
                                        babelrc: false,
                                        configFile: false,
                                        cacheDirectory: true,
                                        compact: false,
                                        highlightCode: true,
                                        presets: [
                                            [
                                                '@babel/preset-env',
                                                {
                                                    modules: false,
                                                }
                                            ]
                                        ]
                                    },
                                },
                                {
                                    loader: 'eslint-loader'
                                },
                            ],
                        },
                        {
                            test: /\.css$/,
                            include: /assets\/tailwind/,
                            use: getStyleLoaders().concat(!!argv.watch ? [] : [
                                {
                                    loader: '@americanexpress/purgecss-loader',
                                    options: {
                                        paths: glob.sync(path.join(__dirname, 'public/wp-content/themes') + '/**/*.+(html|php)', {nodir: true}),
                                        extractors: [
                                            {
                                                extractor: TailwindPurgecssExtractor,
                                                extensions: ['php', 'html'],
                                            }
                                        ],
                                    },
                                },
                            ]),
                        },
                        {
                            test: /\.css$/,
                            use: getStyleLoaders(),
                        },
                        {
                            test: /\.(gif|png|jpe?g|svg)$/i,
                            use: [
                                {
                                    loader: 'file-loader',
                                    options: {
                                        name: '[name].[hash:8].[ext]',
                                        outputPath: 'img/',
                                    }
                                },
                                {
                                    loader: 'img-loader',
                                    options: {
                                        plugins: mode === 'production' && [
                                            require('imagemin-gifsicle')({
                                                interlaced: true,
                                            }),
                                            require('imagemin-mozjpeg')({
                                                progressive: true,
                                                arithmetic: false,
                                            }),
                                            require('imagemin-optipng')({
                                                optimizationLevel: 5,
                                            }),
                                            require('imagemin-svgo')({}),
                                        ]
                                    }
                                },
                            ],
                        },
                        {
                            test: /\.(woff|woff2|eot|ttf|otf)$/,
                            use: [
                                {
                                    loader: 'file-loader',
                                    options: {
                                        name: '[name].[hash:8].[ext]',
                                        outputPath: 'fonts/',
                                    }
                                },
                            ],
                        },
                    ]
                },
            ],
        },
        plugins: [
            new webpack.ProvidePlugin({
                // Automtically detect jQuery and $ as free var in modules
                // and inject the jquery library
                // This is required by many jquery plugins
                jQuery: 'jquery',
                $: 'jquery'
            }),
            new CleanWebpackPlugin(),
            // https://webpack.js.org/guides/caching/#module-identifiers
            new MiniCssExtractPlugin({
                filename: '[name].[contenthash:8].css',
                chunkFilename: '[name].[contenthash:8].css',
            }),
            new WebpackManifestPlugin()
        ]
    };
};
