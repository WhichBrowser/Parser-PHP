module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    clean: {
    	dist: [ 'dist' ],
    },

    copy: {
      dist: {
        files: [
          { expand: true, cwd: 'src', src: ['.htaccess', 'index.php', 'detect.php', 'README.md', 'data/**', 'libraries/**'], dest: 'dist/' },
        ]
      },
    	release: {
			  files: [
				  { expand: true, cwd: 'src', src: ['bower.json', 'composer.json'], dest: 'dist/' },
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
            'src/data/profiles.php': 'http://api.whichbrowser.net/resources/profiles.php',
            'src/data/id-android.php': 'http://api.whichbrowser.net/resources/id-android.php'
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

      api: {
  			options: {
  				src: 'dist/',
  				dest: '/home/niels/sites/api.whichbrowser.net/public_html/rel',
  				host: 'niels@html5test.com',
  			}
    	},

      www: {
        options: {
          src: 'dist/',
          dest: '/home/niels/sites/www.whichbrowser.net/public_html/lib',
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
        cmd: 'php -f ../tools/testrunner.php check'
      },

      compare: {
        cwd: 'tests',
        cmd: 'php -f ../tools/testrunner.php compare'
      },

      compare_all: {
        cwd: 'tests',
        cmd: 'php -f ../tools/testrunner.php -- --all compare'
      },

      rebase: {
        cwd: 'tests',
        cmd: 'php -f ../tools/testrunner.php rebase'
      },

      rebase_all: {
        cwd: 'tests',
        cmd: 'php -f ../tools/testrunner.php -- --all rebase'
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
  grunt.registerTask('tools', ['php:tools']);
  grunt.registerTask('start', ['php:start']);

  grunt.registerTask('test', 'Running unittests...', function() {
    var all = grunt.option('all');
    var rebase = grunt.option('rebase');

    if (rebase) {
      grunt.task.run('exec:rebase' + (all ? '_all' : ''));
    } else {
      grunt.task.run('exec:compare' + (all ? '_all' : ''));
    }
  });


  /* This is a private task for deploying to api.whichbrowser.net */
  grunt.registerTask('deploy', ['exec:check', 'clean', 'copy:dist', 'copy:deploy', 'rsync:api', 'rsync:www']);
};
