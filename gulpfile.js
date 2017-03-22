var gulp = require('gulp');
var sass = require('gulp-sass');
gulp.task('sass',function(){
	return gulp.src('resources/assets/scss/*.scss')
	.pipe(sass())
	.pipe(gulp.dest('public/css'));
});

gulp.task('default',['sass']);
