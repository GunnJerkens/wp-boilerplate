'use strict';

const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const MinifyPlugin = require('babel-minify-webpack-plugin');
require('babel-polyfill');
require('whatwg-fetch');

const extractSass = new ExtractTextPlugin({
  filename: '../style/screen.css'
});

module.exports = (env) => {
  // set plugins
  const plugins = [extractSass];

  if (env.NODE_ENV === 'prod') {
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
                minimize: env.NODE_ENV === 'prod'
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