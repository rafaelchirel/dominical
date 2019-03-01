<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '', 'middleware' => ['auth', 'habilitado']], function() {

	Route::get('/', function () {
	    return view('template.main');
	});

	Route::resource('miembro', 'MiembroController')->except('create');
	Route::get('isbuttonReportMiembro', 'MiembroController@isActiveButtonReporte');
	Route::get('reporte-miembro/{params}','MiembroController@reporte_miembro');

	Route::resource('grupo', 'GrupoController')->except('create');
	Route::post('asignarFacilitador', 'GrupoController@asignarFacilitador');
	Route::get('deleteFacilitadorGrupo/{id}', 'GrupoController@deleteFacilitadorGrupo');
	Route::get('reporte-grupo/{params}', 'GrupoController@reporteGrupo');

	Route::resource('clase', 'ClaseController');
	Route::post('listGrupos', 'ClaseController@getGrupos');
	Route::get('asistenciaMiembro/{id}/{asistencia}', 'ClaseController@asistenciaMiembro');
	Route::get('deleteMiembroClase/{id}','ClaseController@deleteMiembroClase');
	Route::get('selectGroupMiembros/{clase_id}/{grupo_id}', 'ClaseController@selectGroupMiembros');
	Route::post('buttonAsignarMiembroClase', 'ClaseController@buttonAsignarMiembroClase');
	Route::post('claseObservacionNoImpartida', 'ClaseController@claseObservacionNoImpartida');
	Route::post('ofrendaClaseImpartida', 'ClaseController@ofrendaClaseImpartida');
	Route::get('reporte-clase-individual/{id}', 'ClaseController@reporteIndividual');

	Route::resource('usuario', 'UsuarioController', ['except' => ['create','store','show','edit','update']]);
	Route::get('usuario/habilitado/{id}', 'UsuarioController@habilitar');
	Route::get('usuario/resetcontrasena/{id}', 'UsuarioController@resetarContrasena');
	Route::get('usuario/rol/{id}', 'UsuarioController@rol');
	Route::post('usuario/consultarrol', 'UsuarioController@consultarRol');
	Route::get('reporte-user/{id}', 'UsuarioController@reporte_PDF');//reporte
	Route::get('consulta-button-reporte', 'UsuarioController@consultarButtonReporte');

	//Respaldo
	Route::get('respaldo-database', 'BackupController@index');
	Route::get('backup/create', 'BackupController@create');
	Route::get('backup/download/{file_name}', 'BackupController@download');
	Route::get('backup/delete/{file_name}', 'BackupController@delete');

	//Perfil
	Route::get('userperfil', 'UserController@perfilUser');
	Route::put('updatePerfil/{id}', 'PerfilController@update');
	Route::get('changePassword/{password}/{id}', 'PerfilController@changePassword');
	Route::get('userDown/{id}', 'PerfilController@userDown');
});

//Reser password
Route::get('resetpassword', function () {
	return view('auth.reset');
});

Route::post('checkEmail', 'UserController@checkEmail');
Route::post('updatePassword', 'UserController@updatePassword');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


