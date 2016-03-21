
module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-newer');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.initConfig({
        // Reference package.json
        pkg: grunt.file.readJSON('package.json'),

        // Compile SCSS with the Compass Compiler
        compass: {
            compile : {
                options : {
                    sassDir     : 'scss',
                    cssDir      : 'css',
                    outputStyle : 'compressed',
                    cacheDir    : 'scss/.sass-cache',
                    sourcemap   : true
                },
            }
        },
        // Run Autoprefixer on compiled css
        autoprefixer: {
            options: {
                browsers: ['last 3 version', '> 1%', 'ie 8', 'ie 9', 'ie 10'],
                map : true
            },
            theme : {
                src  : 'css/style.css',
                dest : 'css/style.css'
            },
            admin : {
                src  : 'css/admin.css',
                dest : 'css/admin.css'
            },
            login : {
                src  : 'css/login.css',
                dest : 'css/login.css'
            },
            editor : {
                src  : 'css/editor.css',
                dest : 'css/editor.css'
            }
        },
        // JSHint - Check Javascript for errors
        jshint : {
            options : {
                globals  : {
                  jQuery : true
                }
            },
            dist : {
                src     : [ 'js/**/*.js' ],
                ignores : ['js/min/*.js']
            }
        },
        // Combine & minify JS
        uglify : {
            options : {
              sourceMap : true
            },
            theme : {
                files : {
                    'js/min/mpress.min.js' : [ 'js/libs/menutoggler.js', 'js/mpress.js' ]
                }
            },
            admin : {
                files : {
                    'js/min/admin.min.js' : [ 'js/admin.js' ]
                }
            },
            login : {
                files : {
                    'js/min/login.min.js' : [ 'js/login.js' ]
                }
            }
        },

        // Watch
        watch: {
            compass: {
                files: 'scss/**/*.scss',
                tasks: ['compass', 'newer:autoprefixer']
            },
            jsminify: {
                files: 'js/**/*.js',
                tasks: ['uglify'],
            },
            livereload: {
                options: { livereload: true },
                files: ['css/*.css', 'js/min/*.js', '*.html', 'images/*', '*.php'],
            },
        },
    });

    grunt.registerTask('default', ['watch']);
};