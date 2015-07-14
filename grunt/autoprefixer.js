// https://www.npmjs.com/package/grunt-autoprefixer
module.exports = {
    options: {
        browsers: ['last 2 versions', 'ie 8', 'ie 9']
    },

    dist: {
        files: {
            'assets/dist/css/style.css': 'assets/dist/css/style.css'
        }
    }
};