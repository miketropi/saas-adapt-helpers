const mix = require('laravel-mix');

mix
  .js('./src/main.js', './dist/saas-adapt-helpers.bundle.js')
  .js('./src/admin.js', './dist/saas-adapt-helpers.admin.bundle.js')
  .sass('./src/scss/main.scss', 'css/saas-adapt-helpers.bundle.css')
  .setPublicPath('dist')