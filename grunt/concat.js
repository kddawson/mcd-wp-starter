// https://www.npmjs.com/package/grunt-contrib-concat
module.exports = {
    options: {
        banner: '/*! Auto-created <%= grunt.template.today("dd-mm-yyyy") %>, do not modify */\n'
    },

    dist: {
        // concat all files
        src: ['assets/js/*.js'],
        dest: 'assets/dist/js/project.js'
    }
};