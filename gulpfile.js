'use strict';

// Basic elixir requirement
var elixir = require('laravel-elixir');

// Base URLS
var baseBowerPath = __dirname + '/vendor/bower_components/';

elixir(function(mix) {

	// Mix less files
	mix.less('app.less');
	mix.less('api-explorer.less');
	mix.less('front-page.less');

	// Mix scripts
	mix.scripts([
		'jquery/dist/jquery.min.js',
		'bootstrap/dist/js/bootstrap.min.js',
		'bootstrap-material-design/dist/js/material.min.js',
		'bootstrap-material-design/dist/js/ripples.min.js',
		'vue/dist/vue.min.js'
	], 'public/js/vendor.js', baseBowerPath);

	// Mix standalone scripts
	mix.scripts([
		'api-explorer.js'
	], 'public/js/api-explorer.js')

	// Copy required fonts
	mix.copy(baseBowerPath + 'bootstrap/dist/fonts', 'public/fonts/vendor');
	mix.copy(baseBowerPath + 'font-awesome/fonts', 'public/fonts/vendor');
	mix.copy(baseBowerPath + 'Materialize/dist/fonts', 'public/fonts/vendor');

	// Version all generated files
	mix.version([
		'js/vendor.js',
		'css/app.css',
		'css/front-page.css',
		'css/api-explorer.css',
	]);

});
