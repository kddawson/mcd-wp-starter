// https://www.npmjs.com/package/grunt-notify
module.exports = {
    uglify: {
        options: {
            //title: 'Build complete',  // optional
            message: 'JS minified'      // required
        }
    },

    less: {
        options:{
            message: 'Less built'
        }
    },

    cssmin: {
        options:{
            message: 'CSS minified'
        }
    }
};