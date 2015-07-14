// https://www.npmjs.com/package/grunt-concurrent
module.exports = {

    // Task options
    options: {
        limit: 4
    },

    // Dev tasks
    devFirst: [
        'clean',
        'jshint',
        'less',
    ],
    devSecond: [
        'concat',
        'autoprefixer',
        'notify'
    ],

    // Production tasks
    prodFirst: [
        'clean',
        'concat',
        'less',
    ],
    prodSecond: [
        'autoprefixer',
        'cssmin',
        'uglify',
        'notify'
    ]
};
