'use strict';

const path = require('path');
const webpack = require('webpack');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

module.exports = (env) => {
  const mode = env.NODE_ENV === 'local' ? 'development' : env.NODE_ENV;
  const plugins = [
    new MiniCssExtractPlugin({
       filename: "../style/[name].css"
    }),
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(mode)
    })
  ];

  console.log('mode: ', mode);

  return {
    mode: mode,
    entry: {
      scripts: './public/content/themes/gj-boilerplate/js/src/scripts.js',
      styles: './public/content/themes/gj-boilerplate/style/sass/screen.scss'
    },
    output: {
      filename: '[name].bundle.js',
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
          test: /.s?css$/,
          use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
        },
      ]
    },
    optimization: {
      minimizer: [
        new UglifyJsPlugin({
          uglifyOptions: {
            output: {
              comments: false,
            },
          },
        }),
        new CssMinimizerPlugin()
      ],
    },
    plugins: plugins,
  }
};
