const gulp = require('gulp');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const cleanCss = require('gulp-clean-css');
const sassGlob = require('gulp-sass-glob');
const uglify = require('gulp-uglify');
const plumber = require('gulp-plumber');
const prefix = require('gulp-autoprefixer');
const babel = require('gulp-babel');
const rename = require('gulp-rename');


// Process theme styles
gulp.task('styles', (done) => {
  gulp.src('public/**/styles.scss')
    .pipe(plumber())
    .pipe(sassGlob())
    .pipe(sass({
      errLogToConsole: true
    }))
    .pipe(prefix())
    .pipe(cleanCss({
      compatibility: 'ie9'
    }))
    .pipe(rename((file) => {
      file.dirname = file.dirname,
      file.basename = 'styles.min';
      file.extname = '.css';
    }))
    .pipe(gulp.dest('public/'))

  done();
});

// Process theme scripts
gulp.task('scripts', (done) => {
  gulp.src('public/**/scripts.js')
    .pipe(plumber())
    .pipe(babel({
      presets: ['@babel/env']
    }))
    .pipe(uglify())
    .pipe(rename((file) => {
      file.dirname = file.dirname,
      file.basename = 'scripts.min';
      file.extname = '.js';
    }))
    .pipe(gulp.dest('public/'))

  done();
});

// Watch theme assets
gulp.task('watch', () => {
  gulp.watch('public/**/styles.scss', gulp.series('styles'));
  gulp.watch('public/**/scripts.js', gulp.series('scripts'));
})

// Sed build task
gulp.task('build', gulp.series('styles','scripts'));

// Set default task
gulp.task('default', gulp.series('build', 'watch'));