<?php

/**
 * Api defined routes
 */
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
	Route::group(['prefix' => 'v1'], function() {

		// =====================================================
		// = Authentication
		// =====================================================

		post('login', [
			'as' => 'auth.login',
			'uses' => 'AuthController@login'
		]);
		post('register', [
			'as' => 'auth.register',
			'uses' => 'AuthController@register'
		]);
		post('logout', [
			'as' => 'auth.logout',
			'uses' => 'AuthController@logout',
			'middleware' => 'jwt.auth'
		]);

		// =====================================================
		// = Categories
		// =====================================================

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
			'uses' => 'CategoryController@store',
			'middleware' => 'jwt.auth'
		]);
		put('categories/{id}', [
			'as' => 'categories.update',
			'uses' => 'CategoryController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('categories/{id}', [
			'as' => 'categories.destroy',
			'uses' => 'CategoryController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('fairs/{id}/categories', [
			'as' => 'categories.byFair',
			'uses' => 'CategoryController@getByFair'
		]);

		// =====================================================
		// = Comments
		// =====================================================

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
			'uses' => 'CommentController@store',
			'middleware' => 'jwt.auth'
		]);
		put('comments/{id}', [
			'as' => 'comments.update',
			'uses' => 'CommentController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('comments/{id}', [
			'as' => 'comments.destroy',
			'uses' => 'CommentController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('users/{id}/comments', [
			'as' => 'comments.byUser',
			'uses' => 'CommentController@getByUser'
		]);
		get('news/{id}/comments', [
			'as' => 'comments.byNews',
			'uses' => 'CommentController@getByNews'
		]);

		// =====================================================
		// = Event Types
		// =====================================================

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
			'uses' => 'EventTypeController@store',
			'middleware' => 'jwt.auth'
		]);
		put('eventTypes/{id}', [
			'as' => 'eventTypes.update',
			'uses' => 'EventTypeController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('eventTypes/{id}', [
			'as' => 'eventTypes.destroy',
			'uses' => 'EventTypeController@destroy',
			'middleware' => 'jwt.auth'
		]);

		// =====================================================
		// = Fairs
		// =====================================================

		get('fairs', [
			'as' => 'fairs.index',
			'uses' => 'FairController@index'
		]);
		get('fairs/active', [
			'as' => 'fairs.active',
			'uses' => 'FairController@getActiveFairs'
		]);
		get('fairs/{id}', [
			'as' => 'fairs.show',
			'uses' => 'FairController@show'
		]);
		post('fairs', [
			'as' => 'fairs.store',
			'uses' => 'FairController@store',
			'middleware' => 'jwt.auth'
		]);
		put('fairs/{id}', [
			'as' => 'fairs.update',
			'uses' => 'FairController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('fairs/{id}', [
			'as' => 'fairs.destroy',
			'uses' => 'FairController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('users/{id}/fairs', [
			'as' => 'users.fairs',
			'uses' => 'FairController@getByUser'
		]);

		// =====================================================
		// = FairEvents
		// =====================================================

		get('fairEvents', [
			'as' => 'fairEvents.index',
			'uses' => 'FairEventController@index'
		]);
		get('fairEvents/{id}', [
			'as' => 'fairEvents.show',
			'uses' => 'FairEventController@show'
		]);
		post('fairEvents', [
			'as' => 'fairEvents.store',
			'uses' => 'FairEventController@store',
			'middleware' => 'jwt.auth'
		]);
		put('fairEvents/{id}', [
			'as' => 'fairEvents.update',
			'uses' => 'FairEventController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('fairEvents/{id}', [
			'as' => 'fairEvents.destroy',
			'uses' => 'FairEventController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('fairs/{id}/fairEvents', [
			'as' => 'fairs.fairEvents',
			'uses' => 'FairEventController@getByFair'
		]);
		get('eventTypes/{id}/fairEvents', [
			'as' => 'eventTypes.fairEvents',
			'uses' => 'FairEventController@getByEventType'
		]);
		get('users/{id}/attendingFairEvents', [
			'as' => 'users.attendingFairEvents',
			'uses' => 'FairEventController@getByAttendingUser'
		]);

		// =====================================================
		// = Maps
		// =====================================================

		get('maps', [
			'as' => 'maps.index',
			'uses' => 'MapController@index'
		]);
		get('maps/{id}', [
			'as' => 'maps.show',
			'uses' => 'MapController@show'
		]);
		post('maps', [
			'as' => 'maps.store',
			'uses' => 'MapController@store',
			'middleware' => 'jwt.auth'
		]);
		put('maps/{id}', [
			'as' => 'maps.update',
			'uses' => 'MapController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('maps/{id}', [
			'as' => 'maps.destroy',
			'uses' => 'MapController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('fairs/{id}/maps', [
			'as' => 'fairs.maps',
			'uses' => 'MapController@getByFair'
		]);

		// =====================================================
		// = Maps
		// =====================================================

		get('news', [
			'as' => 'news.index',
			'uses' => 'NewsController@index'
		]);
		get('news/{id}', [
			'as' => 'news.show',
			'uses' => 'NewsController@show'
		]);
		post('news', [
			'as' => 'news.store',
			'uses' => 'NewsController@store',
			'middleware' => 'jwt.auth'
		]);
		put('news/{id}', [
			'as' => 'news.update',
			'uses' => 'NewsController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('news/{id}', [
			'as' => 'news.destroy',
			'uses' => 'NewsController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('fairs/{id}/news', [
			'as' => 'fairs.news',
			'uses' => 'NewsController@getByFair'
		]);

		// =====================================================
		// = Speakers
		// =====================================================

		get('speakers', [
			'as' => 'speakers.index',
			'uses' => 'SpeakerController@index'
		]);
		get('speakers/{id}', [
			'as' => 'speakers.show',
			'uses' => 'SpeakerController@show'
		]);
		post('speakers', [
			'as' => 'speakers.store',
			'uses' => 'SpeakerController@store',
			'middleware' => 'jwt.auth'
		]);
		put('speakers/{id}', [
			'as' => 'speakers.update',
			'uses' => 'SpeakerController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('speakers/{id}', [
			'as' => 'speakers.destroy',
			'uses' => 'SpeakerController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('fairEvents/{id}/speakers', [
			'as' => 'fairEvents.speakers',
			'uses' => 'SpeakerController@getByFairEvent'
		]);

		// =====================================================
		// = Sponsors
		// =====================================================

		get('sponsors', [
			'as' => 'sponsors.index',
			'uses' => 'SponsorController@index'
		]);
		get('sponsors/{id}', [
			'as' => 'sponsors.show',
			'uses' => 'SponsorController@show'
		]);
		post('sponsors', [
			'as' => 'sponsors.store',
			'uses' => 'SponsorController@store',
			'middleware' => 'jwt.auth'
		]);
		put('sponsors/{id}', [
			'as' => 'sponsors.update',
			'uses' => 'SponsorController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('sponsors/{id}', [
			'as' => 'sponsors.destroy',
			'uses' => 'SponsorController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('fairs/{id}/sponsors', [
			'as' => 'fairs.sponsors',
			'uses' => 'SponsorController@getByFair'
		]);
		get('sponsorRanks/{id}/sponsors', [
			'as' => 'sponsorRanks.sponsors',
			'uses' => 'SponsorController@getBySponsorRank'
		]);

		// =====================================================
		// = Sponsor Ranks
		// =====================================================

		get('sponsorRanks', [
			'as' => 'sponsorRanks.index',
			'uses' => 'SponsorRankController@index'
		]);
		get('sponsorRanks/{id}', [
			'as' => 'sponsorRanks.show',
			'uses' => 'SponsorRankController@show'
		]);
		post('sponsorRanks', [
			'as' => 'sponsorRanks.store',
			'uses' => 'SponsorRankController@store',
			'middleware' => 'jwt.auth'
		]);
		put('sponsorRanks/{id}', [
			'as' => 'sponsorRanks.update',
			'uses' => 'SponsorRankController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('sponsorRanks/{id}', [
			'as' => 'sponsorRanks.destroy',
			'uses' => 'SponsorRankController@destroy',
			'middleware' => 'jwt.auth'
		]);

		// =====================================================
		// = Stands
		// =====================================================

		get('stands', [
			'as' => 'stands.index',
			'uses' => 'StandController@index'
		]);
		get('stands/{id}', [
			'as' => 'stands.show',
			'uses' => 'StandController@show'
		]);
		post('stands', [
			'as' => 'stands.store',
			'uses' => 'StandController@store',
			'middleware' => 'jwt.auth'
		]);
		put('stands/{id}', [
			'as' => 'stands.update',
			'uses' => 'StandController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('stands/{id}', [
			'as' => 'stands.destroy',
			'uses' => 'StandController@destroy',
			'middleware' => 'jwt.auth'
		]);
		get('fairs/{id}/stands', [
			'as' => 'fairs.stands',
			'uses' => 'StandController@getByFair'
		]);

		// =====================================================
		// = Users
		// =====================================================

		get('users', [
			'as' => 'users.index',
			'uses' => 'UserController@index'
		]);
		get('users/{id}', [
			'as' => 'users.show',
			'uses' => 'UserController@show'
		]);
		post('users', [
			'as' => 'users.store',
			'uses' => 'UserController@store',
			'middleware' => 'jwt.auth'
		]);
		put('users/{id}', [
			'as' => 'users.update',
			'uses' => 'UserController@update',
			'middleware' => 'jwt.auth'
		]);
		delete('users/{id}', [
			'as' => 'users.destroy',
			'uses' => 'UserController@destroy',
			'middleware' => 'jwt.auth'
		]);

	});
});
