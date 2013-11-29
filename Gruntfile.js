/*global module:false*/
module.exports = function (grunt) {
    grunt.initConfig({
        less: {
            style: {
                options: {
                    yuicompress: false
                },
                src: 'assets/less/style.less',
                dest: 'web/wp-content/themes/wordpress-boilerplate/style.css'
            }
        },
        uglify: {
            libs: {
                src: [
                ],
                dest: 'web/wp-content/themes/wordpress-boilerplate/assets/js/libs.js'
            },
            script: {
                src: [
                    'assets/js/script.js'
                ],
                dest: 'web/wp-content/themes/wordpress-boilerplate/assets/js/script.js'
            }
        },
        imagemin: {
            theme: {
                expand: true,
                src: ['web/wp-content/themes/wordpress-boilerplate/**/*.*']
            }
        },
        svgmin: {
            theme: {
                options: {
                    plugins: [{
                        removeViewBox: false
                    }]
                },
                expand: true,
                src: ['web/wp-content/themes/wordpress-boilerplate/**/*.svg']
            }
        },
        watch: {
            less: {
                files: 'assets/**/*.less',
                tasks: 'less'
            },
            uglify: {
                files: 'assets/**/*.js',
                tasks: 'uglify'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-svgmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Default task.
    grunt.registerTask('default', ['less', 'uglify']);
};
