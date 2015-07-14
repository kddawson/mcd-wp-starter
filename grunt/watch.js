module.exports = {
    options: {
        // ===========================================================================
        // livereload requires browser plugin and desktop app
        //
        // See: http://feedback.livereload.com/knowledgebase/articles/67441-how-do-i-start-using-livereload
        // https://github.com/gruntjs/grunt-contrib-watch#optionslivereload
        //
        // ===========================================================================

        livereload: 1337,
    },

    // for stylesheets, watch CSS and LESS files
    // https://www.npmjs.com/package/grunt-newer (failing)
    stylesheets: {
        files: ['assets/less/**/*.less', 'assets/dist/css/*.css'],
        tasks: ['less', 'autoprefixer', 'cssmin', 'notify:less'],
    },

    // for scripts, run concat and uglify
    scripts: {
        files: ['assets/js/*.js'],
        tasks: ['newer:concat', 'newer:uglify', 'notify:uglify'],
        options: {
            spawn: false,
        },
    }
};