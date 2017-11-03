const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const WebpackAssetsManifest = require('webpack-assets-manifest');

const webpackConfig = {
  target: 'web',
  stats: true,
    entry: {
      main: [/*'./assets/webpack-public-path', */'./assets/main'],
      'main-critical': [/*'./assets/webpack-public-path', */'./assets/main/index-critical']
    },
    output: {
      path: path.join(__dirname, 'web/wp-content/themes/mlp-academics/assets/scripts'),
      publicPath: '/wp-content/themes/mlp-academics/assets/scripts/',
      filename: '[name].js', // append ?[hash] to fix entry chunks not updated correctly
      chunkFilename: '[name].[chunkhash].js'
    },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel-loader'
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
            'postcss-loader'
          ]
        })
      },
      {
        test: /\.(gif|png|jpe?g|svg)$/i,
        loaders: [
          {
            loader: 'file-loader',
            options: {
              name: 'static/[hash].[ext]',
            },
          },
          {
            loader: 'image-webpack-loader',
            options: {
              mozjpeg: {
                quality: 85
              },
              pngquant:{
                quality: "65-90",
                speed: 4
              },
              svgo:{
                plugins: [
                  {
                    removeViewBox: false
                  },
                  {
                    removeEmptyAttrs: false
                  }
                ]
              },
              gifsicle: {
                optimizationLevel: 7,
                interlaced: false
              },
              optipng: {
                optimizationLevel: 7,
                interlaced: false
              }
            }
          },
        ],
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
        loader: 'file-loader',
        options: {
          name: 'static/[hash].[ext]',
        }
      }

    ]

  },

  plugins: [
    new webpack.ProvidePlugin({
      // Automtically detect jQuery and $ as free var in modules
      // and inject the jquery library
      // This is required by many jquery plugins
      jQuery: 'jquery',
      $: 'jquery'
    }),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      },
      output: {
        comments: false
      }
    }),
    new webpack.optimize.OccurrenceOrderPlugin(true),
    new webpack.NoEmitOnErrorsPlugin(),
    new ExtractTextPlugin('[name].[chunkhash].css'),
    new WebpackAssetsManifest()
  ]
};

module.exports = webpackConfig;