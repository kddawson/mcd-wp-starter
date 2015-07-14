// https://www.npmjs.com/package/grunt-contrib-cssmin
module.exports = {
    options: {
        banner: '/*! Auto-created <%= grunt.template.today("dd-mm-yyyy") %>, do not modify */\n'
    },

    build: {
        files: {
            'assets/dist/css/style.min.css': 'assets/dist/css/style.css'
        }
    }
};