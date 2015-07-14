// https://www.npmjs.com/package/grunt-contrib-uglify
module.exports = {
    options: {
        // the banner is inserted at the top of the output
        banner: '/*! Auto-created <%= grunt.template.today("dd-mm-yyyy") %>, do not modify */\n'
    },

    dist: {
        files: {
            'assets/dist/js/project.min.js': 'assets/dist/js/project.js'
        }
    }
};