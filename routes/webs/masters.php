<?php

Route::prefix('/masters')->namespace('Masters')->middleware(['auth'])->group(function () {


  Route::prefix('/business')->name('business.')->group(function () {

    Route::get('/show/{id}', 'BusinessController@create')->name('show');

    Route::post('/delete/{id}', 'BusinessController@delete')->name('delete');

    Route::post('/create', 'BusinessController@save')->name('store');
    Route::get('/create', 'BusinessController@create')->name('create');

    Route::get('/getList', 'BusinessController@getList')->name('getList');
    Route::get('/', 'BusinessController@index')->name('index');

  });


  Route::prefix('/persons')->name('persons.')->group(function () {

    Route::get('/search/{param?}', 'PersonsController@search')->name('search');

    Route::get('/show/{id}', 'PersonsController@create')->name('show');

    Route::post('/delete/{id}', 'PersonsController@delete')->name('delete');

    Route::post('/create', 'PersonsController@save')->name('store');
    Route::get('/create', 'PersonsController@create')->name('create');

    Route::get('/getOnlyPersons', 'PersonsController@getOnlyPersons')->name('getOnlyPersons');
    Route::get('/', 'PersonsController@index')->name('index');
  });


  Route::prefix('/periods')->name('periods.')->group(function () {

    Route::get('/listByCompany/{person_id}', 'PeriodsController@getListPeriods')
      ->name('periods.getListByCompany');

    Route::get('/search/{param?}', 'PeriodsController@search')->name('search');

  });





});
