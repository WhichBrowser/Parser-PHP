module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    clean: {
    	dist: [ 'dist' ],
    },

    copy: {
    	dist: {
			  files: [
				  { expand: true, cwd: 'src', src: ['detect.php', 'README.md', 'data/**', 'libraries/**'], dest: 'dist/' },
			  ]
      }
    },

    git_deploy: {
      release: {
        options: {
          url:      'git@github.com:WhichBrowser/Test.git',
          branch:   'master',
          message:  'Autocommit from development'
        },
        src: 'dist'
      },
    },

    php: {
        start: {
            options: {
                base: 'tools',
                port: 8080,
                keepalive: true,
                open: true
            }
        }
    },

    exec: {
      compare: {
        cwd: 'tests',
        cmd: 'php -f ../tools/testrunner.php compare'
      },

      rebase: {
        cwd: 'tests',
        cmd: 'php -f ../tools/testrunner.php rebase'
      }
    }
  });


  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-git-deploy');
  grunt.loadNpmTasks('grunt-exec');
  grunt.loadNpmTasks('grunt-php');



  grunt.registerTask('default', ['exec:compare', 'clean', 'copy']);
  grunt.registerTask('release', ['exec:compare', 'clean', 'copy', 'git_deploy']);
  grunt.registerTask('start', ['php']);

  grunt.registerTask('test', 'Running unittests...', function() {
    var rebase = grunt.option('rebase');

    if (rebase) {
      grunt.task.run('exec:rebase');
    } else {
      grunt.task.run('exec:compare');
    }
  });

};
