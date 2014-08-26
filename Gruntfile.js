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

    buildcontrol: {
      options: {
        dir: 'dist',
        commit: true,
        push: true,
        message: 'Built %sourceName% from commit %sourceCommit% on branch %sourceBranch%'
      },
      release: {
        options: {
          remote: 'git@github.com:WhichBrowser/Test.git',
          branch: 'master',
          tag:    "v<%= pkg.version %>"
        }
      },
    },

    bump: {
      options: {
        files: ['package.json'],
        updateConfigs: ['pkg'],
        commit: true,
        commitMessage: 'Release v%VERSION%',
        commitFiles: ['package.json'],
        createTag: false,
        push: false,
      }
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


  grunt.loadNpmTasks('grunt-build-control');
  grunt.loadNpmTasks('grunt-bump');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-exec');
  grunt.loadNpmTasks('grunt-php');


  grunt.registerTask('default', ['exec:compare', 'clean', 'copy']);
  grunt.registerTask('release', ['exec:compare', 'clean', 'bump', 'copy', 'buildcontrol']);
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
