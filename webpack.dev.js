const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const WebpackAssetsManifest = require('webpack-assets-manifest');

const webpackConfig = {
  target: 'web',
  stats: true,
    entry: {
      main: [/*'./assets/webpack-public-path', */'./assets/'],
      'main-critical': [/*'./assets/webpack-public-path', */'./assets/index-critical']
    },
    output: {
      path: path.join(__dirname, 'web/wp-content/themes/wordpress-boilerplate/assets/scripts'),
      publicPath: '/wp-content/themes/wordpress-boilerplate/assets/scripts/',
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
                minimize: false,
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
      $: 'jquery',
      jQuery: 'jquery'
    }),
    // OccurrenceOrderPlugin is needed for long-term caching to work properly.
    // See http://mxs.is/googmv
    new webpack.optimize.OccurrenceOrderPlugin(true),
    new webpack.NoEmitOnErrorsPlugin(),
    new ExtractTextPlugin('[name].[chunkhash].css'),
    new WebpackAssetsManifest()
  ]
};

module.exports = webpackConfig;