module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    clean: {
    	dist: [ 'dist' ],
    },

    copy: {
      dist: {
        files: [
          { expand: true, cwd: 'src/parser', src: ['data/**', 'src/**', 'README.md'], dest: 'dist/parser/' },
          { expand: true, cwd: 'src/server', src: ['.htaccess', 'index.php', 'detect.php', 'README.md', 'src/**'], dest: 'dist/server/' },
          { expand: true, cwd: 'src/testrunner/data', src: ['**/*.yaml'], dest: 'dist/testrunner/data/' },
          { expand: true, cwd: 'src/testrunner', src: ['runner.php', 'src/**'], dest: 'dist/testrunner/' },
          { expand: true, cwd: 'src/parser', src: ['data/**', 'src/**'], dest: 'dist/legacy/' },
          { expand: true, cwd: 'src/server', src: ['.htaccess', 'index.php', 'detect.php', 'README.md', 'src/**'], dest: 'dist/legacy/' },
          { expand: true, cwd: 'src/legacy', src: ['libraries/**', 'README.md'], dest: 'dist/legacy/' },
        ]
      },
    	release: {
			  files: [
          { expand: true, cwd: 'src/parser', src: ['composer.json'], dest: 'dist/parser/' },
          { expand: true, cwd: 'src/server', src: ['composer.json'], dest: 'dist/server/' },
          { expand: true, cwd: 'src/testrunner', src: ['composer.json'], dest: 'dist/testrunner/' },
          { expand: true, cwd: 'src/legacy', src: ['composer.json'], dest: 'dist/legacy/' },
			  ]
      },
      deploy: {
        files: [
          { expand: true, cwd: 'private', src: ['.htaccess', 'log.php'], dest: 'dist/legacy/' },
        ]
      }
    },

    wget: {
      options: {
        overwrite: true
      },
      generate: {
        files: {
            'src/parser/data/profiles.php': 'http://api.whichbrowser.net/resources/profiles.php',
            'src/parser/data/id-android.php': 'http://api.whichbrowser.net/resources/id-android.php'
        }
      }
    },

    buildcontrol: {
      options: {
        commit: true,
        push: true,
        connectCommits: false
      },
      legacy: {
        options: {
          dir: 'dist/legacy',
          remote: 'git@github.com:WhichBrowser/Legacy.git',
          branch: 'master',
          tag:    "v<%= pkg.version %>",
          message: 'Built %sourceName% from commit %sourceCommit% on WhichBrowser/WhichBrowser on branch %sourceBranch%'
        }
      },
      server: {
        options: {
          dir: 'dist/server',
          remote: 'git@github.com:WhichBrowser/Server.git',
          branch: 'master',
          tag:    "v<%= pkg.version %>",
          message: 'Built %sourceName% from commit %sourceCommit% on WhichBrowser/WhichBrowser on branch %sourceBranch%'
        }
      },
      parser: {
        options: {
          dir: 'dist/parser',
          remote: 'git@github.com:WhichBrowser/Parser.git',
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
  				src: 'dist/legacy/',
  				dest: '/var/www/api.whichbrowser.net/web/rel',
  				host: 'admin@server.html5test.com',
  			}
    	},

      www: {
        options: {
          src: 'dist/legacy/',
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
        server: {
            options: {
                base: 'src/server',
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
        cwd: 'dist',
        cmd: 'php -f testrunner/runner.php check'
      },

      compare: {
        cwd: 'src/testrunner',
        cmd: 'php -f runner.php compare'
      },

      rebase: {
        cwd: 'src/testrunner',
        cmd: 'php -f runner.php rebase'
      },

      updatechrome: {
        cwd: 'tools',
        cmd: 'php -f update-chrome.php'
      }
    },

    gitcheck: {
      branches: [ 'dev' ]
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
  grunt.loadNpmTasks('grunt-gitcheck');


  grunt.registerTask('default', ['generate', 'clean', 'copy:dist', 'exec:check']);
  grunt.registerTask('generate', ['wget'], ['exec:updatechrome']);
  grunt.registerTask('release', ['clean', 'bump', 'copy:dist', 'copy:release', 'exec:check', 'gitcheck', 'buildcontrol:legacy', 'buildcontrol:server', 'buildcontrol:parser', 'buildcontrol:testrunner']);
  grunt.registerTask('tools', ['php:tools']);
  grunt.registerTask('server', ['php:server']);

  grunt.registerTask('test', 'Running unittests...', function() {
    var rebase = grunt.option('rebase');

    if (rebase) {
      grunt.task.run('exec:rebase');
    } else {
      grunt.task.run('exec:compare');
    }
  });


  /* This is a private task for deploying to api.whichbrowser.net */
  grunt.registerTask('deploy', ['clean', 'copy:dist', 'copy:deploy', 'exec:check', 'gitcheck', 'rsync:api', 'rsync:www']);
};
