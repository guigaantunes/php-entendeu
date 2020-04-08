module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
	    options: {
			noCache: true,
		    update: true,
		    sourcemap: 'file'
		},
	    dist: {
			options: {                       // Target options 
				style: 'compressed'
			},
			files: [{
				expand: true,
				cwd: 'sass',
				src: ['*.scss'],
				dest: 'css',
				ext: '.css'
			}]
      	}
    },
	watch: {
      sass: {
        files: 'sass/**/*.scss',
        tasks: ['sass'],
      }
    },
  });
  
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');

  grunt.registerTask('deploy', ['sass']);
  grunt.registerTask('default', ['sass','watch']);
};