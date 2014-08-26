module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    clean: {
    	dist: [ 'dist' ],
    },

    copy: {
      dist: {
        files: [
          { expand: true, cwd: 'src', src: ['.htaccess', 'detect.php', 'README.md', 'data/**', 'libraries/**'], dest: 'dist/' },
        ]
      },
    	release: {
			  files: [
				  { expand: true, cwd: 'src', src: ['composer.json'], dest: 'dist/' },
			  ]
      },
      deploy: {
        files: [
          { expand: true, cwd: 'private', src: ['.htaccess', 'log.php'], dest: 'dist/' },
        ]
      }
    },

    wget: {
      options: {
        overwrite: true
      },
      generate: {
        files: {
          'src/data/profiles.php': 'http://api.whichbrowser.net/resources/profiles.php'
        }
      }
    },

    buildcontrol: {
      options: {
        dir: 'dist',
        commit: true,
        push: true,
        message: 'Built %sourceName% from commit %sourceCommit% on branch %sourceBranch%',
        connectCommits: false
      },
      release: {
        options: {
          remote: 'git@github.com:WhichBrowser/WhichBrowser.git',
          branch: 'master',
          tag:    "v<%= pkg.version %>"
        }
      },
    },

    rsync: {
  		options: {
  			exclude: [".DS_Store"],
  			recursive: true
  		},

      deploy: {
  			options: {
  				src: 'dist/',
  				dest: '/home/niels/sites/api.whichbrowser.net/public_html/rel',
  				host: 'niels@html5test.com',
  			}
    	}
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
      check: {
        cwd: 'tests',
        cmd: 'php -f ../tools/testrunner.php check'
      },

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
  grunt.loadNpmTasks('grunt-wget');
  grunt.loadNpmTasks('grunt-rsync');


  grunt.registerTask('default', ['exec:check', 'clean', 'copy:dist']);
  grunt.registerTask('generate', ['wget']);
  grunt.registerTask('release', ['exec:check', 'clean', 'bump', 'copy:dist', 'copy:release', 'buildcontrol']);
  grunt.registerTask('start', ['php']);

  grunt.registerTask('test', 'Running unittests...', function() {
    var rebase = grunt.option('rebase');

    if (rebase) {
      grunt.task.run('exec:rebase');
    } else {
      grunt.task.run('exec:compare');
    }
  });


  /* This is a private task for deploying to api.whichbrowser.net */
  grunt.registerTask('deploy', ['exec:check', 'clean', 'copy:dist', 'copy:deploy', 'rsync']);
};
