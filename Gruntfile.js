module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        exec: {
            bower_install: {
                command: 'bower install'
            },
            composer_install: {
                command: 'composer install'
            },
            server : {
                command : "php -S 0.0.0.0:8043",
                cwd : "public/"
            }
        },
    });
    grunt.loadNpmTasks('grunt-exec');
    grunt.task.registerTask('development',['exec']);
}
