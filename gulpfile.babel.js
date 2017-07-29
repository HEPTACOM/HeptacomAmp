import gulp from "gulp";
import browserify from "browserify";
import source from "vinyl-source-stream";
import less from "gulp-less";

gulp.task('build', ()  => {
    return browserify([
        './Resources/views/backend/_resources/KskAmp/BackendApplication/js/app.js'
    ])
        .bundle()
        .pipe(source('KskAmpBackendApplication.js'))
        .pipe(gulp.dest('./Resources/views/backend/ksk_amp_backend_application/js'));
});

gulp.task('style', () => {
    return gulp.src('./Resources/views/backend/_resources/KskAmp/BackendApplication/less/app.less')
        .pipe(less())
        .pipe(source('KskAmpBackendApplication.css'))
        .pipe(gulp.dest('./Resources/views/backend/ksk_amp_backend_application/css'));
});

gulp.task('fonts', () => {
    return gulp.src('./node_modules/font-awesome/fonts/*')
        .pipe(gulp.dest('./Resources/views/backend/ksk_amp_backend_application/fonts'))
});