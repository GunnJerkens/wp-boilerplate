'use strict';

const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const MinifyPlugin = require('babel-minify-webpack-plugin');
// const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
require('babel-polyfill');
require('whatwg-fetch');

const extractSass = new ExtractTextPlugin({
  filename: '../style/screen.css'
});

module.exports = (env) => {
  // set plugins - uncomment BrowserSyncPlugin and update host/ proxy values to enable browser-sync
  const plugins = [
    extractSass,
    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify(env.NODE_ENV)
      }
    })
    // new BrowserSyncPlugin({
    //   open: 'external',
    //   host: 'example.test',
    //   port: 9000,
    //   proxy: 'http://example.test:8080/'
    // })
  ];

  if (env.NODE_ENV === 'production') {
    plugins.push(
      new MinifyPlugin()
    );
  }

  return {
    entry: [
      'babel-polyfill',
      'whatwg-fetch',
      './public/content/themes/gj-boilerplate/js/src/scripts.js',
      './public/content/themes/gj-boilerplate/style/sass/screen.scss'
    ],
    output: {
      filename: 'main.js',
      path: path.resolve(__dirname, 'public/content/themes/gj-boilerplate/js')
    },
    externals: {
      jquery: 'jQuery'
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          loader: 'babel-loader',
          options: {
            presets: ['env']
          }
        },
        {
          test: /\.scss$/,
          loader: extractSass.extract([
            {
              loader: 'css-loader',
              options: {
                minimize: env.NODE_ENV === 'production'
              }
            },
            'postcss-loader',
            'sass-loader'
          ])
        }
      ]
    },
    plugins: plugins
  }
};
