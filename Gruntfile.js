var extend = require('extend');

module.exports = function (grunt) {
    var webpackConfig = require('./webpack.config.js');
    var webpackWatchConfig = extend({}, webpackConfig, {
        watch: true,
        keepalive: true,
        progress: true,
        failOnError: false
    });

    grunt.initConfig({
        webpack: {
            build: webpackConfig,
            watch: webpackWatchConfig
        },
        clean: {
            assets: ['web/wp-content/themes/wordpress-boilerplate/assets/*']
        },
        imagemin: {
            assets: {
                expand: true,
                src: [
                    'web/wp-content/themes/wordpress-boilerplate/img/**/*.{jpg,jpeg,png,gif}'
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-webpack');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-imagemin');

    grunt.registerTask('watch', ['clean:assets', 'webpack:watch']);
    grunt.registerTask('build', ['clean:assets', 'webpack:build']);
    grunt.registerTask('default', ['build']);
};
