<?php

use Carbon\Carbon;
use ExpoHub\Category;
use ExpoHub\Comment;
use ExpoHub\EventType;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\Map;
use ExpoHub\News;
use ExpoHub\Speaker;
use ExpoHub\Sponsor;
use ExpoHub\SponsorRank;
use ExpoHub\Stand;
use ExpoHub\User;

trait DatabaseCreator
{
	/**
	 * @param array $parameters
	 * @return User
	 */
	public function createUser(array $parameters = [])
	{
		User::unguard();
		$user = User::create(array_merge([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		], $parameters));
		User::reguard();
		return $user;
	}

	/**
	 * @param array $parameters
	 * @return EventType
	 */
	public function createEventType(array $parameters = [])
	{
		EventType::unguard();
		$eventType = EventType::create(array_merge([
			'name' => 'foo'
		], $parameters));
		EventType::reguard();
		return $eventType;
	}

	/**
	 * @param array $parameters
	 * @return SponsorRank
	 */
	public function createSponsorRank(array $parameters = [])
	{
		SponsorRank::unguard();
		$sponsorRank = SponsorRank::create(array_merge([
			'name' => 'foo'
		], $parameters));
		SponsorRank::reguard();
		return $sponsorRank;
	}

	/**
	 * Requires a User object before creation
	 *
	 * @param $userId
	 * @param array $parameters
	 * @return Fair
	 */
	public function createFair($userId, array $parameters = [])
	{
		Fair::unguard();
		$fair = Fair::create(array_merge([
			'name' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'website' => 'qux',
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now(),
			'address' => 'foo-bar',
			'latitude' => 9.9,
			'longitude' => 8.8,
			'user_id' => $userId
		], $parameters));
		Fair::reguard();
		return $fair;
	}

	/**
	 * Requires a Fair object before creation
	 *
	 * @param $fairId
	 * @param array $parameters
	 * @return Category
	 */
	public function createCategory($fairId, array $parameters = [])
	{
		Category::unguard();
		$category = Category::create(array_merge([
			'name' => 'foo',
			'fair_id' => $fairId
		], $parameters));
		Category::reguard();
		return $category;
	}

	/**
	 * Requires a Fair and an EventType objects before creation
	 *
	 * @param $fairId
	 * @param $eventTypeId
	 * @param array $parameters
	 * @return FairEvent
	 */
	public function createFairEvent($fairId, $eventTypeId, array $parameters = [])
	{
		FairEvent::unguard();
		$fairEvent = FairEvent::create(array_merge([
			'title' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'date' => Carbon::now(),
			'location' => 'qux',
			'fair_id' => $fairId,
			'event_type_id' => $eventTypeId
		], $parameters));
		FairEvent::reguard();
		return $fairEvent;
	}

	/**
	 * Requires a Fair object before creation
	 *
	 * @param $fairId
	 * @param array $parameters
	 * @return Map
	 */
	public function createMap($fairId, array $parameters = [])
	{
		Map::unguard();
		$map = Map::create(array_merge([
			'name' => 'foo',
			'image' => 'bar',
			'fair_id' => $fairId
		], $parameters));
		Map::reguard();
		return $map;
	}

	/**
	 * Requires a Fair object before creation
	 *
	 * @param $fairId
	 * @param array $parameters
	 * @return News
	 */
	public function createNews($fairId, array $parameters = [])
	{
		News::unguard();
		$news = News::create(array_merge([
			'title' => 'foo',
			'content' => 'bar',
			'image' => 'baz',
			'fair_id' => $fairId
		], $parameters));
		News::reguard();
		return $news;
	}

	/**
	 * Requires FairEvent object before creation
	 *
	 * @param $fairEventId
	 * @param array $parameters
	 * @return Speaker
	 */
	public function createSpeaker($fairEventId, array $parameters = [])
	{
		Speaker::unguard();
		$speaker = Speaker::create(array_merge([
			'name' => 'foo',
			'picture' => 'bar',
			'description' => 'baz',
			'fair_event_id' => $fairEventId
		], $parameters));
		Speaker::reguard();
		return $speaker;
	}

	/**
	 * Requires Fair and SponsorRank objects before creation
	 *
	 * @param $fairId
	 * @param $sponsorRankId
	 * @param array $parameters
	 * @return Sponsor
	 */
	public function createSponsor($fairId, $sponsorRankId, array $parameters = [])
	{
		Sponsor::unguard();
		$sponsor = Sponsor::create(array_merge([
			'name' => 'foo',
			'logo' => 'bar',
			'slogan' => 'baz',
			'website' => 'qux',
			'fair_id' => $fairId,
			'sponsor_rank_id' => $sponsorRankId
		], $parameters));
		Sponsor::reguard();
		return $sponsor;
	}

	/**
	 * Requires News and User objects before creation
	 *
	 * @param $newsId
	 * @param $userId
	 * @param array $parameters
	 * @return Comment
	 */
	public function createComment($newsId, $userId, array $parameters = [])
	{
		Comment::unguard();
		$comment = Comment::create(array_merge([
			"text" => "foo",
			"news_id" => $newsId,
			"user_id" => $userId
		], $parameters));
		Comment::reguard();

		return $comment;
	}

	/**
	 * Requires Fair object before creation
	 *
	 * @param $fairId
	 * @param array $parameters
	 * @return Stand
	 */
	public function createStand($fairId, array $parameters = [])
	{
		Stand::unguard();
		$stand = Stand::create(array_merge([
			'name' => 'foo',
			'description' => 'bar',
			'image' => 'baz.jpg',
			'fair_id' => $fairId
		], $parameters));
		Stand::reguard();

		return $stand;
	}
}