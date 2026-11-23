module.exports = {
  profile: 'component-development',
  integration: false,
  profiles: {
    'component-development': {
      operations: ['sass_compile', 'webpack_build', 'css_process'],
      build: {
        operations: ['sass_compile', 'webpack_build', 'css_process'],
      },
      sassCompile: {
        entryPoints: [{
          source: 'resources/components/index/src/style/main-style.scss',
          destination: 'resources/components/index/src/generated/main-style.css',
        }],
      },
      cssProcess: {
        sourceRoot: 'resources/components/index/src/generated',
        destinationRoot: 'resources/assets/style/index/classic',
      },
      webpackBuild: {
        entryPoints: [{
          source: 'resources/components/index/src/js/main-scripts.js',
          destination: 'resources/assets/script/index/classic/main-scripts.js',
        }],
      },
      browserSync: {
        enabled: false,
        // proxy: "http://local.wp/",
        // proxy: "http://tc-1.multisite/",
        // server: { baseDir: "assets" },
        host: '127.0.0.1',
        port: 3000,
        open: false,
        notify: false,
        ui: false,
      },
    },
  },
};
