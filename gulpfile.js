var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass',function(){
	return gulp.src('./assets/scss/custom.scss')
	.pipe(sass().on('error',sass.logError))
	.pipe(gulp.dest('./assets/css'));
});



gulp.task('default',function(){
	gulp.watch('./assets/scss/custom.scss',['sass']);
});
