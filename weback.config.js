const path = require('path');

module.exports = {
  resolve: {
    alias: {
      '@utils': path.resolve(__dirname, 'resources/js/utils'),
      '@styles': path.resolve(__dirname, 'resources/sass'),
      '@mixins': path.resolve(__dirname, 'resources/js/mixins'),
    },
  },
};
