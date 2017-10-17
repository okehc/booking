<?php
Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/calendar', 'Admin\SystemCalendarController@index'); 
  
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('reservacions', 'Admin\ReservacionsController');
    Route::post('minuta_show', 'Admin\ReservacionsController@minuta')->name('reservacions.sendMinuta');
    Route::get('minuta_create', 'Admin\ReservacionsController@minuta')->name('reservacions.sendMinuta');
    Route::post('minuta',  'Admin\ReservacionsController@minuta')->name('reservacions.sendMinuta');

    Route::post('search_show', 'Admin\ReservacionsController@search')->name('reservacions.search');
    Route::get('search_create', 'Admin\ReservacionsController@search')->name('reservacions.search');
    Route::post('search',  'Admin\ReservacionsController@search')->name('reservacions.search');
      
    Route::resource('ubicaciones', 'Admin\UbicacionesController');
    Route::post('ubicaciones_mass_destroy', ['uses' => 'Admin\UbicacionesController@massDestroy', 'as' => 'ubicaciones.mass_destroy']);
    Route::post('ubicaciones_restore/{id}', ['uses' => 'Admin\UbicacionesController@restore', 'as' => 'ubicaciones.restore']);
    Route::delete('ubicaciones_perma_del/{id}', ['uses' => 'Admin\UbicacionesController@perma_del', 'as' => 'ubicaciones.perma_del']);
    Route::resource('accesos', 'Admin\AccesosController');
    Route::post('accesos_mass_destroy', ['uses' => 'Admin\AccesosController@massDestroy', 'as' => 'accesos.mass_destroy']);
    Route::post('accesos_restore/{id}', ['uses' => 'Admin\AccesosController@restore', 'as' => 'accesos.restore']);
    Route::delete('accesos_perma_del/{id}', ['uses' => 'Admin\AccesosController@perma_del', 'as' => 'accesos.perma_del']);
    Route::resource('seccions', 'Admin\SeccionsController');
    Route::post('seccions_mass_destroy', ['uses' => 'Admin\SeccionsController@massDestroy', 'as' => 'seccions.mass_destroy']);
    Route::post('seccions_restore/{id}', ['uses' => 'Admin\SeccionsController@restore', 'as' => 'seccions.restore']);
    Route::delete('seccions_perma_del/{id}', ['uses' => 'Admin\SeccionsController@perma_del', 'as' => 'seccions.perma_del']);
    Route::resource('items', 'Admin\itemsController');
    Route::post('items_mass_destroy', ['uses' => 'Admin\itemsController@massDestroy', 'as' => 'items.mass_destroy']);
    Route::post('items_restore/{id}', ['uses' => 'Admin\itemsController@restore', 'as' => 'items.restore']);
    Route::delete('items_perma_del/{id}', ['uses' => 'Admin\itemsController@perma_del', 'as' => 'items.perma_del']);
    Route::resource('departamentos', 'Admin\DepartamentosController');
    Route::post('departamentos_mass_destroy', ['uses' => 'Admin\DepartamentosController@massDestroy', 'as' => 'departamentos.mass_destroy']);
    Route::post('departamentos_restore/{id}', ['uses' => 'Admin\DepartamentosController@restore', 'as' => 'departamentos.restore']);
    Route::delete('departamentos_perma_del/{id}', ['uses' => 'Admin\DepartamentosController@perma_del', 'as' => 'departamentos.perma_del']);

    Route::resource('evento','Admin\EventoController');
    Route::get('api','EventoController@api'); //ruta que nos devuelve los eventos en formato json
    Route::resource('busquedas', 'Admin\BusquedasController');


    #Route::post('/spatie/media/upload', 'Admin\SpatieMediaController@create')->name('media.upload');
    #Route::post('/spatie/media/remove', 'Admin\SpatieMediaController@destroy')->name('media.remove');
    

});


