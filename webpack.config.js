'use strict';

const path = require('path');
const webpack = require('webpack');
const MinifyPlugin = require('babel-minify-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');


require('core-js');

module.exports = (env) => {
  const mode = env.NODE_ENV === 'local' ? 'development' : env.NODE_ENV;
  const plugins = [
    new MiniCssExtractPlugin({
       filename: "../style/screen.css"
    }),
    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify(env.NODE_ENV)
      }
    })
  ];

  console.log('mode: ', mode);

  if (env.NODE_ENV === 'production') {
    plugins.push(
      new MinifyPlugin()
    );
  }

  return {
    mode: mode,
    entry: [
      'core-js',
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
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
          }
        },
        {
          test: /\.scss$/,
          use: [{
            loader: MiniCssExtractPlugin.loader
          }, {
            loader: "css-loader"
          }, {
            loader: "sass-loader"
          }]
        },
      ]
    },
    plugins: plugins
  }
};
