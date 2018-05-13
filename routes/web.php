<?php
session_start();
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

Route::prefix('importar')->group(function () {

  Route::post('persons', 'ImportarController@persons')->name('importar.persons');
  Route::get('/', 'ImportarController@index')->name('importar.index');
  });

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//users module
Route::prefix('/security')->middleware(['auth'])->group(function () {

  Route::get('/users{param?}', 'UsersController@index')
    ->name('users.index');
  Route::get('/users/create', 'UsersController@create')
    ->name('users.create');
  Route::get('/users/{id}/edit', 'UsersController@edit')
    ->name('users.edit');
  Route::get('/users/{id}/modules', 'UsersController@showModules')
    ->name('users.modules');
  Route::put('/users/{id}/modules', 'UsersController@storeModules')
    ->name('users.modulesStore');
  //find an user by username()
  Route::get('/users/validateNewDuplicated',
    'UsersController@validateNewDuplicated');

  Route::post('/users', 'UsersController@store')
    ->name('users.store');
  Route::post('/users/{id}', 'UsersController@update')
    ->name('users.update');
});

//catalogs routes



//
Route::prefix('/basics')->middleware(['auth'])->group( function(){

  Route::get('/company/{id}/sons', 'CompanyController@getCompanySons')
    ->name('company.sons');

  Route::get('/company/{id}/setCurrent', 'CompanyController@setCurrent')
    ->name('company.set.current');
});

//path general, dont change
Route::get('/', 'SiteController@index')->name('site');
Route::get('/admin', 'HomeController@index')->name('admin');
