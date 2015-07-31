// Global
// $npm install -g gulp
// $npm install gulp-load-plugins

// Install local per project
// $npm install --save-dev (installs all packages in package.json)

// Run process
// $gulp

// Include Gulp
var gulp = require('gulp');

// Include gulp- plugins from package.json
var plugins = require('gulp-load-plugins')();


var del         = require('del'),
    q           = require('q'),
    path        = require('path'),
    fs          = require('fs'),
    svgmin      = require('gulp-svgmin');


// Compile & Minify Theme CSS from LESS files
// =============================================================================
gulp.task('css', function () {

    var onError = function (err) {
        plugins.notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep"
        })(err);

        this.emit('end');
    };

    return gulp.src('assets/less/style.less')

    .pipe(plugins.plumber({ errorHandler: onError }))
    .pipe(plugins.less({compress: true}))
    .pipe(plugins.autoprefixer('last 2 version', 'ie 8', 'ie 9'))
    .pipe(plugins.minifyCss({keepBreaks: false}))
    .pipe(plugins.rename({suffix: '.min'}))
    .pipe(gulp.dest('assets/dist/css'))
    .pipe(plugins.notify({ message: 'CSS task complete', onLast: true }));
});


// Concatenate & Minify Theme JS
// =============================================================================
gulp.task('js', function () {
    return gulp.src('assets/js/*.js')
    .pipe(plugins.concat('project.js'))
    .pipe(plugins.rename({suffix: '.min'}))
    .pipe(plugins.uglify())
    .pipe(gulp.dest('assets/dist/js'))
    .pipe(plugins.notify({ message: 'JS task complete' }));
});


// Concatenate & Minify Bootstrap JS
// bootstrap-popover.js has to be after bootstrap-tooltip.js
// Only use what's needed
// =============================================================================
gulp.task('bootstrapJS', function () {
    return gulp.src([
        'bower_components/bootstrap-less/js/transition.js',
        'bower_components/bootstrap-less/js/alert.js',
        'bower_components/bootstrap-less/js/button.js',
        'bower_components/bootstrap-less/js/carousel.js',
        'bower_components/bootstrap-less/js/collapse.js',
        'bower_components/bootstrap-less/js/dropdown.js',
        'bower_components/bootstrap-less/js/modal.js',
        'bower_components/bootstrap-less/js/tooltip.js',
        'bower_components/bootstrap-less/js/popover.js',
        'bower_components/bootstrap-less/js/scrollspy.js',
        'bower_components/bootstrap-less/js/tab.js',
        'bower_components/bootstrap-less/js/affix.js'
    ])
    .pipe(plugins.concat('bootstrap.js'))
    .pipe(plugins.rename({suffix: '.min'}))
    .pipe(plugins.uglify())
    .pipe(gulp.dest('assets/dist/js'))
    .pipe(plugins.notify({ message: 'Bootstrap JS task complete' }));
});


// SVG
// =============================================================================
gulp.task('svg', function() {
    return gulp.src('assets/svg/*.svg')
        .pipe(plugins.svgmin())
        .pipe(gulp.dest('assets/dist/icons'));
});


gulp.task('svg2png', ['svg'], function() {
    return gulp.src('assets/svg/*.svg')
        .pipe(plugins.svg2png())
        .pipe(gulp.dest('assets/dist/icons'));
});


// Optimise images (once)
// =============================================================================
gulp.task('images', function() {
    return gulp.src('assets/img/**/*.*')
    .pipe(plugins.cache(plugins.imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
    .pipe(gulp.dest('assets/dist/img'))
    .pipe(plugins.notify({ message: 'Images task complete' }));
});


// Watch for changes in files
// =============================================================================
gulp.task('watch', function () {
    gulp.watch('assets/less/**/*.less', ['css']);
    gulp.watch('assets/js/*.js', ['js']);
    gulp.watch('assets/svg/*.svg', ['svg2png']);
});


// Clean
// =============================================================================
gulp.task('clean', function(cb) {
    del(['assets/dist/css', 'assets/dist/js', 'assets/dist/img'], cb);
});


// Default Task
// =============================================================================
gulp.task('default', ['clean'], function() {
    gulp.start('css', 'js', 'images');
});
