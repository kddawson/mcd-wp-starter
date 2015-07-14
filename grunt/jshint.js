// https://www.npmjs.com/package/grunt-contrib-jshint
// https://www.npmjs.com/package/jshint-stylish
module.exports = {
    options: {
        // use jshint-stylish to make our errors look and read good
        reporter: require('jshint-stylish')
    },
    target: ['assets/js/*.js'],

    // when this task is run, lint the Gruntfile and all js files in src. ** denotes all folders
    build: ['gruntfile.js', 'assets/js/*.js']
};