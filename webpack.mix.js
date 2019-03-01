let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.scripts([
			'resources/assets/template/js/jquery-3.3.1.min.js',
			'resources/assets/template/js/bootstrap.js',
			'resources/assets/template/js/jquery.metisMenu.js',
			'resources/assets/template/js/custom.js',
         	'resources/assets/template/js/fontawesome.js',
         	'resources/assets/template/js/bootstrap-show-password.js',
			//Plugins
			'resources/assets/plugins/toastr/toastr.js',
			'resources/assets/js/validation-jquery.js'
			], 'public/js/template.js')

   		.styles([
   		'resources/assets/template/css/bootstrap.css',
			'resources/assets/template/css/basic.css',
			'resources/assets/template/css/custom.css',
         //Plugins
			'resources/assets/template/css/pretty-checkbox.min.css',
			'resources/assets/plugins/toastr/toastr.css'
   		], 'public/css/template.css')

			.js(['resources/assets/js/app.js'],'public/js/app.js');//logica vuejs
