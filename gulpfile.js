var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');

gulp.task('default', ['css', 'js']);

var styles = [
    'bower_components/bootstrap/dist/css/bootstrap.min.css'
];

gulp.task('css', function(){
    gulp.src(styles)
        .pipe(concat('app.css'))
        .pipe(cleanCSS())
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest('web/css'));
});

var assets = [
    "bower_components/jquery/dist/jquery.min.js",
    "bower_components/bootstrap/dist/js/bootstrap.min.js"
];

gulp.task('js', function () {
    gulp.src(assets)
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('web/js'));
});
