<?php

/**
 * Api defined routes
 */
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
	Route::group(['prefix' => 'v1'], function() {

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
			'uses' => 'EventTypeController@store'
		]);
		put('eventTypes/{id}', [
			'as' => 'eventTypes.update',
			'uses' => 'EventTypeController@update'
		]);
		delete('eventTypes/{id}', [
			'as' => 'eventTypes.destroy',
			'uses' => 'EventTypeController@destroy'
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
			'uses' => 'FairController@store'
		]);
		put('fairs/{id}', [
			'as' => 'fairs.update',
			'uses' => 'FairController@update'
		]);
		delete('fairs/{id}', [
			'as' => 'fairs.destroy',
			'uses' => 'FairController@destroy'
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
			'uses' => 'FairEventController@store'
		]);
		put('fairEvents/{id}', [
			'as' => 'fairEvents.update',
			'uses' => 'FairEventController@update'
		]);
		delete('fairEvents/{id}', [
			'as' => 'fairEvents.destroy',
			'uses' => 'FairEventController@destroy'
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
			'uses' => 'MapController@store'
		]);
		put('maps/{id}', [
			'as' => 'maps.update',
			'uses' => 'MapController@update'
		]);
		delete('maps/{id}', [
			'as' => 'maps.destroy',
			'uses' => 'MapController@destroy'
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
			'uses' => 'NewsController@store'
		]);
		put('news/{id}', [
			'as' => 'news.update',
			'uses' => 'NewsController@update'
		]);
		delete('news/{id}', [
			'as' => 'news.destroy',
			'uses' => 'NewsController@destroy'
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
			'uses' => 'SpeakerController@store'
		]);
		put('speakers/{id}', [
			'as' => 'speakers.update',
			'uses' => 'SpeakerController@update'
		]);
		delete('speakers/{id}', [
			'as' => 'speakers.destroy',
			'uses' => 'SpeakerController@destroy'
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
			'uses' => 'SponsorController@store'
		]);
		put('sponsors/{id}', [
			'as' => 'sponsors.update',
			'uses' => 'SponsorController@update'
		]);
		delete('sponsors/{id}', [
			'as' => 'sponsors.destroy',
			'uses' => 'SponsorController@destroy'
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
			'uses' => 'SponsorRankController@store'
		]);
		put('sponsorRanks/{id}', [
			'as' => 'sponsorRanks.update',
			'uses' => 'SponsorRankController@update'
		]);
		delete('sponsorRanks/{id}', [
			'as' => 'sponsorRanks.destroy',
			'uses' => 'SponsorRankController@destroy'
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
			'uses' => 'StandController@store'
		]);
		put('stands/{id}', [
			'as' => 'stands.update',
			'uses' => 'StandController@update'
		]);
		delete('stands/{id}', [
			'as' => 'stands.destroy',
			'uses' => 'StandController@destroy'
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
			'uses' => 'UserController@store'
		]);
		put('users/{id}', [
			'as' => 'users.update',
			'uses' => 'UserController@update'
		]);
		delete('users/{id}', [
			'as' => 'users.destroy',
			'uses' => 'UserController@destroy'
		]);

	});
});
