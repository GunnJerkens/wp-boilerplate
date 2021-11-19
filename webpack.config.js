'use strict';

const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env) => {
  const mode = env.NODE_ENV === 'local' ? 'development' : env.NODE_ENV;
  const plugins = [
    new MiniCssExtractPlugin({
       filename: "./public/content/themes/gj-boilerplate/style/[name].css"
    }),
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(mode)
    })
  ];

  stats: 'errors-only',

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
          test: /\.scss$/i,
          use: [
            // {
            //   loader: MiniCssExtractPlugin.loader
            // },
            // Creates `style` nodes from JS strings
            "style-loader",
            // Translates CSS into CommonJS
            "css-loader",
            // Compiles Sass to CSS
            "sass-loader",
          ]
        },
        {
          test: /\.css$/i,
          use: [{
            loader: MiniCssExtractPlugin.loader
          }, {
            loader: "css-loader"
          }]
        },
      ]
    },
    plugins: plugins,
  }
};
