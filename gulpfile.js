var gulp = require('gulp'),
    sass = require('gulp-sass'),
    minify = require('gulp-minify-css'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    livereload = require('gulp-livereload'),
    lr = require('tiny-lr'),
    rev = require('gulp-rev'),
    del = require('del'),
    util = require('gulp-util'),
    fs = require('fs'),
    path = require('path'),
    autoprefix = require('gulp-autoprefixer'),
    ngAnnotate = require('gulp-ng-annotate'),
    argv = require('yargs').argv,
    gulpif = require('gulp-if'),
    plumber = require('gulp-plumber'),
    runSequence = require('run-sequence'),
    templateCache = require('gulp-angular-templatecache');

var paths = {
    'css': './public/css/',
    'js': './public/js/'
};

var styles = [
    './resources/assets/sass/site.scss'
];


gulp.task('cleanup', function() {
    del('./public/build/*', { force: true });
    return del('./rev-manifest.json', { force: true });
});

gulp.task('css', function() {
    return gulp.src(styles)
        .pipe(sass({precision: 10}))
        .on('error', handleError)
        .pipe(autoprefix('last 5 versions'))
        .pipe(gulp.dest(paths.css))

        .pipe(livereload())

        .pipe(minify())
        .on('error', handleError)
        .pipe(gulpif(argv.production, rename({suffix: '.min'})))
        .pipe(gulpif(argv.production, rev()))
        .pipe(gulpif(argv.production, gulp.dest('./public/build')))
        .pipe(gulpif(argv.production, rev.manifest({base: 'public/build', merge: true})))
        .pipe(gulpif(argv.production, gulp.dest('./public/build')));
});

gulp.task('dashboard_app', function (done) {
    var arr = ["./public/dashboard_app/**/*.js"];
    if(argv.production) {
        arr.push('./public/build/dashboard_templates.js');
    }
    return gulp.src(arr)
        .pipe(plumber())
        .pipe(concat("dashboard_app.js"))
        .pipe(gulp.dest(paths.js))
        .pipe(gulpif(argv.production, rename({suffix: '.min'})))
        .pipe(gulpif(argv.production, rev()))
        .pipe(gulpif(argv.production, ngAnnotate()))
        .pipe(gulpif(argv.production, uglify({preserveComments: 'some'})))
        .pipe(gulpif(argv.production, gulp.dest('./public/build')))
        .pipe(gulpif(argv.production, rev.manifest({base: 'public/build', merge: true})))
        .pipe(gulpif(argv.production, gulp.dest('public/build')))
        .pipe(livereload());
});

gulp.task('dashboard_templates', function(done) {
    var options = {
        root: 'dashboard_app',
        standalone: false,
        module: 'dashboard.templates'
    };
    gulp.src([
        './public/dashboard_app/**/*.html'
    ])
        .pipe(templateCache('dashboard_templates.js', options))
        .pipe(gulp.dest('./public/build'))
        .on('end', done);
});

gulp.task('blade', function() {
    return gulp.src("./public/index.php")
        .pipe(livereload());
});

gulp.task('watch', ['default'], function() {
    livereload.listen();
    gulp.watch('./resources/assets/sass/**/*.scss', ['css']);
    gulp.watch('./resources/views/**/*.blade.php', ['blade']);
    gulp.watch('./public/dashboard_app/**/*.*', ['dashboard_app']);
});

gulp.task('build', function() {
    return runSequence(
        'cleanup',
        'dashboard_templates',
        'default'
    );
});



gulp.task('default', function() {
    runSequence(
        'css',
        'dashboard_app'
    );
});

function handleError(err) {
    util.log(util.colors.red(err.toString()));
    this.emit('end');
}