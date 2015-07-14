// Per machine: npm install -g grunt-cli
// Per project: npm install --save-dev

// For WordPress localisation
// See: http://code.tutsplus.com/tutorials/using-grunt-with-wordpress-development--cms-21743


// See: http://www.html5rocks.com/en/tutorials/tooling/supercharging-your-gruntfile/
module.exports = function(grunt) {

    // measures the time each task takes
    require('time-grunt')(grunt);

    // load grunt config
    require('load-grunt-config')(grunt, {
        jitGrunt: true
    });

};
