<?php

Route::prefix('/taxes')->namespace('Taxes')->middleware(['auth'])->group(function () {

  Route::prefix('/receipt')->name('receipt.')->group(function () {

    Route::get('/{type_id?}', 'ReceiptsController@index')->name('index');
    Route::get('/create/{type_id}', 'ReceiptsController@create')->name('create');
    Route::get('/edit/{id}', 'ReceiptsController@edit')->name('edit');

    Route::post('/delete/{id}', 'ReceiptsController@delete')->name('delete');
    Route::post('/create', 'ReceiptsController@save')->name('store');

    Route::get('/listByCompany/{person_id}', 'ReceiptsController@getListReceipts')
      ->name('getListByCompany');
  });


  Route::prefix('/settle')->name('settle.')->group(function () {

    Route::get('/recalculate/{type}/{period_liquidation_id}/{person_id}',
     'SettleController@recalculate')->name('recalculate');

    Route::get('/listByCompany/{person_id}', 'SettleController@getListSettle')
      ->name('getListByCompany');

    Route::get('/{type_id?}', 'SettleController@index')->name('index');
    Route::get('/show/{id}', 'SettleController@show')->name('show');
    Route::get('/find/{id}', 'SettleController@find')->name('find');

    Route::get('/close/{id}', 'SettleController@close')->name('close');

    Route::post('/generate', 'SettleController@generate')->name('generate');
    Route::post('/store', 'SettleController@save')->name('store');

    Route::get('/delete/{id}', 'SettleController@showDelete')->name('showDelete');
    Route::delete('/delete', 'SettleController@confirmDelete')->name('confirmDelete');

    Route::patch('/open', 'SettleController@open')->name('open');
  });

});
