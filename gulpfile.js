var gulp = require('gulp'),
        js = require('gulp-uglify'),
        concat = require('gulp-concat'),
        sass = require('gulp-sass'),
        browser = require('gulp-browserify'),
        sourcemaps = require('gulp-sourcemaps');
gulp.task('sass-dev', function() {
    return gulp.src('assets/style.scss')
            .pipe(sourcemaps.init())
            .pipe(concat('style.min.css'))
            .pipe(sass({ outputStyle: 'expanded' }))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('webroot/css'));
});
gulp.task('js-dev', function() {
    return gulp.src(['assets/script.js'])
            .pipe(sourcemaps.init())
            .pipe(browser())
            .pipe(js({ mangle: false, compress: false, output: { beautify: true } }))
            .pipe(concat('script.min.js'))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('webroot/js'));
});
gulp.task('watch', function() {
    gulp.watch('assets/scss/**/*.scss', gulp.series('sass-dev'));
    gulp.watch('assets/js/**/*.js', gulp.series('js-dev'));
});
gulp.task('developer', gulp.parallel('sass-dev', 'js-dev', 'watch'));
gulp.task('sass-prod', function() {
    return gulp.src('assets/sass/style.scss')
            .pipe(sourcemaps.init())
            .pipe(concat('style.min.css'))
            .pipe(sass({ outputStyle: 'compressed' }))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('webroot/css'));
});
gulp.task('js-prod', function() {
    return gulp.src('assets/js/script.js')
            .pipe(sourcemaps.init())
            .pipe(concat('script.min.js'))
            .pipe(js())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('webroot/js'));
});
gulp.task('production', gulp.parallel('sass-prod', 'js-prod'));