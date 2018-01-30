var path_to_css = './assets/css/datetimepicker.css';
var path_to_min_css = './assets/css/';

var gulp = require('gulp');
var minify_css = require("gulp-minify-css");
var rename = require('gulp-rename');

gulp.task('minify-datetimepicker', function () {
    gulp.src(path_to_css)
        .pipe(minify_css())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(path_to_min_css))       // put minimized file
});


var del = require('del');
var web_assets_path = '../../../../backend/web/assets/*'

gulp.task('delete-yii2-assets', function () {   // delete yii assets
    del([web_assets_path], {force: true} );
});


gulp.task('watch', function () {
    gulp.watch(path_to_css, [ 'delete-yii2-assets','minify-datetimepicker'])
});


gulp.task('default', ['delete-yii2-assets', 'minify-datetimepicker', 'watch']);
