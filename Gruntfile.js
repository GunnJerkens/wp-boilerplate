'use strict';

module.exports = function (grunt) {

  // load all grunt tasks
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),
 
    uglify: {
      min: {
        files: {
          'public/content/themes/gj-boilerplate/js/main.js': ['public/content/themes/gj-boilerplate/js/src/libs/*.js','public/content/themes/gj-boilerplate/js/src/*.js']
        }
      }
    },
 
    compass: {
      dist: {
        options: {
          basePath: 'public/content/themes/gj-boilerplate/style',
          config: 'public/content/themes/gj-boilerplate/style/config.rb',
          sassDir: 'public/content/themes/gj-boilerplate/style/sass',
          cssDir: 'public/content/themes/gj-boilerplate/style',
          environment: 'production',
          outputStyle: 'compressed',
          force: true
        }
      }
    },

    watch: {
      options: {
        livereload: true
      },
      scripts: {
        files: ['public/content/themes/gj-boilerplate/js/src/*.js','public/content/themes/gj-boilerplate/js/src/libs/*.js'],
        tasks: ['uglify']
      },
      styles: {
        files: ['public/content/themes/gj-boilerplate/style/sass/*.scss'],
        tasks: ['compass']
      }
    },
  });
 
  // Development task checks and concatenates JS, compiles SASS preserving comments and nesting, runs dev server, and starts watch
  grunt.registerTask('default', ['compass', 'uglify', 'watch']);
 
 }