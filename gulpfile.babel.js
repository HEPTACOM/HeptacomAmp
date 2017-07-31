import gulp from "gulp";
import browserify from "browserify";
import source from "vinyl-source-stream";
import less from "gulp-less";

gulp.task('build', ()  => {
    return browserify([
        './node_modules/uikit/dist/js/uikit.js',
        './Resources/views/backend/_resources/KskAmp/BackendApplication/js/app.js'
    ])
        .bundle()
        .pipe(source('KskAmpBackendApplication.js'))
        .pipe(gulp.dest('./Resources/views/backend/ksk_amp_backend_application/js'));
});

gulp.task('assets', () => {
    return gulp.src('./Resources/views/backend/_resources/KskAmp/BackendApplication/assets/*')
        .pipe(gulp.dest('./Resources/views/backend/ksk_amp_backend_application/assets'))
});

gulp.task('style', ['assets'], () => {
    return gulp.src('./Resources/views/backend/_resources/KskAmp/BackendApplication/less/app.less')
        .pipe(less())
        .pipe(gulp.dest('./Resources/views/backend/ksk_amp_backend_application/css'));
});

gulp.task('fonts', () => {
    return gulp.src('./node_modules/font-awesome/fonts/*')
        .pipe(gulp.dest('./Resources/views/backend/ksk_amp_backend_application/fonts'))
});