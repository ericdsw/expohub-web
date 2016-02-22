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

		// Categories - SubResource
		get('fairs/{id}/categories', [
			'as' => 'categories.byFair',
			'uses' => 'CategoryController@getByFair'
		]);

		// Comments
		get('comments', [
			'as' => 'comments.index',
			'uses' => 'CommentController@index'
		]);
		get('comments/{id}', [
			'as' => 'comments.show',
			'uses' => 'CommentController@show'
		]);
		post('comments', [
			'as' => 'comments.store',
			'uses' => 'CommentController@store'
		]);
		put('comments/{id}', [
			'as' => 'comments.update',
			'uses' => 'CommentController@update'
		]);
		delete('comments/{id}', [
			'as' => 'comments.destroy',
			'uses' => 'CommentController@destroy'
		]);

		// Comments - SubResource
		get('users/{id}/comments', [
			'as' => 'comments.byUser',
			'uses' => 'CommentController@getByUser'
		]);
		get('news/{id}/comments', [
			'as' => 'comments.byNews',
			'uses' => 'CommentController@getByNews'
		]);

		// Event Types
		get('eventTypes', [
			'as' => 'eventTypes.index',
			'uses' => 'EventTypeController@index'
		]);
		get('eventTypes/{id}', [
			'as' => 'eventTypes.show',
			'uses' => 'EventTypeController@show'
		]);
		post('eventTypes', [
			'as' => 'eventTypes.store',
			'uses' => 'EventTypeController@store'
		]);
		put('eventTypes/{id}', [
			'as' => 'eventTypes.update',
			'uses' => 'EventTypeController@update'
		]);
		delete('eventTypes/{id}', [
			'as' => 'eventTypes.destroy',
			'uses' => 'eventTypeController@destroy'
		]);

	});
});
