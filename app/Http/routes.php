<?php

/**
 * Api defined routes
 */
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
	Route::group(['prefix' => 'v1'], function() {

		// Categories
		get('categories', [
			'as' => 'categories.index',
			'uses' => 'CategoryController@index'
		]);
		get('categories/{id}', [
			'as' => 'categories.show',
			'uses' => 'CategoryController@show'
		]);
		post('categories', [
			'as' => 'categories.store',
			'uses' => 'CategoryController@store'
		]);
		put('categories/{id}', [
			'as' => 'categories.update',
			'uses' => 'CategoryController@update'
		]);
		delete('categories/{id}', [
			'as' => 'categories.destroy',
			'uses' => 'CategoryController@destroy'
		]);

	});
});
