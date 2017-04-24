var gulp = require('gulp');
// gulp-sass
var sass = require('gulp-sass'); 
// autoprefixer
var autoprefixer = require('gulp-autoprefixer'); 
// sourceMappingURL 
var sourcemaps = require('gulp-sourcemaps'); 
// minify css
var cleanCSS = require('gulp-clean-css'); 
// minfi js
var uglify = require('gulp-uglify'); 
// merge multiple file in a single file 
var concat = require('gulp-concat'); 
// font-awesome unicode issue
var sassUnicode = require('gulp-sass-unicode'); 
// browser-sync
var browserSync = require('browser-sync').create();

//clean dist
var del = require('del');
// default task
gulp.task('default', ['clean', 'styles', 'scripts', 'fonts']);
// gulp watch task
gulp.task('watch', ['serve']);
// Style
gulp.task('styles', function() {
   return gulp.src([
    'assets/styles/*.scss', 
    'assets/styles/*.css'
   ])
  .pipe(sourcemaps.init())
  .pipe(sass().on('error', sass.logError))
  .pipe(sassUnicode())
  .pipe(concat('main.css'))
  //.pipe(cleanCSS())
  .pipe(autoprefixer({
    browsers: [
      'last 2 versions',
      'android 4',
      'opera 12'
    ]
   }))
    .pipe(sourcemaps.write('/'))
    .pipe(gulp.dest('dist/styles'))
    .pipe(browserSync.stream());
});
// Scripts
gulp.task('scripts', function () {
  return gulp.src([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/tether/dist/js/tether.js',
    'node_modules/bootstrap/dist/js/bootstrap.js',
    'assets/scripts/navigation.js',
    'assets/scripts/skip-link-focus-fix.js',
    'assets/scripts/main.js'
    ])
    .pipe(sourcemaps.init())
    .pipe(concat('main.js'))
    //.pipe(uglify())
    .pipe(sourcemaps.write('/'))
    .pipe(gulp.dest('dist/scripts'))
    .pipe(browserSync.stream());
});
// Fonts
gulp.task('fonts', function() {
    return gulp.src([
    'node_modules/font-awesome/fonts/*', 
    'node_modules/font-awesome/fonts/*'
    ])
    .pipe(gulp.dest('dist/fonts/'));
});
// Browser Sync
gulp.task('serve', function() {
    browserSync.init({
        proxy: 'http://endless.upcoders.dev/',
        files: ['{inc,template-parts}/**/*.php', '*.php'],
    });
    gulp.watch('assets/styles/*', ['styles'], function(done){
      browserSync.reload();
    });
    gulp.watch('assets/scripts/*', ['scripts'], function(done){
      browserSync.reload();
    });
});

gulp.task('clean', function() {
  return del.sync('dist');
})