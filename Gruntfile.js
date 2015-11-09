module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    clean: {
    	dist: [ 'dist/whichbrowser', 'dist/testrunner' ],
    },

    copy: {
      dist: {
        files: [
          { expand: true, cwd: 'src', src: ['.htaccess', 'index.php', 'detect.php', 'README.md', 'data/**', 'libraries/**'], dest: 'dist/whichbrowser/' },
          { expand: true, cwd: 'tests/data', src: ['**/*.yaml'], dest: 'dist/testrunner/data/' },
          { expand: true, cwd: 'tests', src: ['runner.php'], dest: 'dist/testrunner/' },
        ]
      },
    	release: {
			  files: [
				  { expand: true, cwd: 'src', src: ['bower.json', 'composer.json'], dest: 'dist/whichbrowser/' },
          { expand: true, cwd: 'tests', src: ['composer.json'], dest: 'dist/testrunner/' },
			  ]
      },
      deploy: {
        files: [
          { expand: true, cwd: 'private', src: ['.htaccess', 'log.php'], dest: 'dist/whichbrowser/' },
        ]
      }
    },

    wget: {
      options: {
        overwrite: true
      },
      generate: {
        files: {
            'src/data/profiles.php': 'http://api.whichbrowser.net/resources/profiles.php',
            'src/data/id-android.php': 'http://api.whichbrowser.net/resources/id-android.php'
        }
      }
    },

    buildcontrol: {
      options: {
        commit: true,
        push: true,
        connectCommits: false
      },
      library: {
        options: {
          dir: 'dist/whichbrowser',
          remote: 'git@github.com:WhichBrowser/WhichBrowser.git',
          branch: 'master',
          tag:    "v<%= pkg.version %>",
          message: 'Built %sourceName% from commit %sourceCommit% on WhichBrowser/WhichBrowser on branch %sourceBranch%'
        }
      },
      testrunner: {
        options: {
          dir: 'dist/testrunner',
          remote: 'git@github.com:WhichBrowser/Testrunner.git',
          branch: 'master',
          tag:    "v<%= pkg.version %>",
          message: 'Built %sourceName% from commit %sourceCommit% on WhichBrowser/WhichBrowser on branch %sourceBranch%'
        }
      },
    },

    rsync: {
  		options: {
  			exclude: [".DS_Store"],
  			recursive: true
  		},

      api: {
  			options: {
  				src: 'dist/whichbrowser/',
  				dest: '/var/www/api.whichbrowser.net/web/rel',
  				host: 'admin@server.html5test.com',
  			}
    	},

      www: {
        options: {
          src: 'dist/whichbrowser/',
          dest: '/var/www/whichbrowser.net/web/lib',
          host: 'admin@server.html5test.com',
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
                base: 'src',
                port: 8080,
                keepalive: true,
                open: true
            }
        },
        tools: {
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
        cmd: 'php -f ../dist/testrunner/runner.php check'
      },

      compare: {
        cwd: 'tests',
        cmd: 'php -f ../dist/testrunner/runner.php compare'
      },

      rebase: {
        cwd: 'tests',
        cmd: 'php -f ../dist/testrunner/runner.php rebase'
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


  grunt.registerTask('default', ['clean', 'copy:dist', 'exec:check']);
  grunt.registerTask('generate', ['wget']);
  grunt.registerTask('release', ['clean', 'bump', 'copy:dist', 'copy:release', 'exec:check', 'buildcontrol:library', 'buildcontrol:testrunner']);
  grunt.registerTask('tools', ['php:tools']);
  grunt.registerTask('start', ['php:start']);

  grunt.registerTask('test', 'Running unittests...', function() {
    var rebase = grunt.option('rebase');

    if (rebase) {
      grunt.task.run('exec:rebase');
    } else {
      grunt.task.run('exec:compare');
    }
  });


  /* This is a private task for deploying to api.whichbrowser.net */
  grunt.registerTask('deploy', ['clean', 'copy:dist', 'copy:deploy', 'exec:check', 'rsync:api', 'rsync:www']);
};
