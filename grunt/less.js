// https://www.npmjs.com/package/grunt-contrib-less
module.exports = {
    build: {
        files: {
            'assets/dist/css/style.css': 'assets/less/style.less'
        }
    }
};