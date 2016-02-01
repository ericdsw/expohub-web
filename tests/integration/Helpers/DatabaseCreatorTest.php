<?php


use Carbon\Carbon;
use ExpoHub\EventType;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\News;
use ExpoHub\SponsorRank;
use ExpoHub\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DatabaseCreatorTest extends TestCase
{
	use DatabaseMigrations;

	/** @var SystemUnderTest */
	private $systemUnderTest;

	public function setUp()
	{
		parent::setUp();
		$this->systemUnderTest = new SystemUnderTest();
	}

	/** @test */
	public function it_creates_a_user()
	{
		$userParameters = [
			'id' => 7,
			'username' => 'user_username',
			'email' => 'user_email',
			'password' => 'user_password',
		];

		$this->systemUnderTest->createUser($userParameters);

		$this->seeInDatabase('users', $userParameters);
	}

	/** @test */
	public function it_creates_event_type()
	{
		$eventTypeParameters = [
			'id' => 5,
			'name' => 'event_type_name'
		];

		$this->systemUnderTest->createEventType($eventTypeParameters);

		$this->seeInDatabase('event_types', $eventTypeParameters);
	}

	/** @test */
	public function it_creates_sponsor_rank()
	{
		$sponsorRankParameters = [
			'id' => 6,
			'name' => 'sponsor_rank_name'
		];

		$this->systemUnderTest->createSponsorRank($sponsorRankParameters);

		$this->seeInDatabase('sponsor_ranks', $sponsorRankParameters);
	}

	/** @test */
	public function it_creates_fair()
	{
		$user = User::create([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		]);

		$fairParameters = [
			'name' => 'fair_name',
			'image' => 'fair_image',
			'description' => 'fair_description',
			'website' => 'fair_website',
			'starting_date' => Carbon::now()->addDays(3),
			'ending_date' => Carbon::now()->addDays(5),
			'address' => 'fair_address',
			'latitude' => 45.0,
			'longitude' => 45.0,
		];

		$this->systemUnderTest->createFair($user->id, $fairParameters);

		$this->seeInDatabase('fairs', array_merge([
			'user_id' => $user->id
		], $fairParameters));
	}

	/** @test */
	public function it_creates_category()
	{
		$user = User::create([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		]);

		$fair = Fair::create([
			'name' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'website' => 'qux',
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now(),
			'address' => 'foo-bar',
			'latitude' => 9.9,
			'longitude' => 8.8,
			'user_id' => $user->id
		]);

		$categoryParameters = [
			'name' => 'category_name'
		];

		$this->systemUnderTest->createCategory($fair->id, $categoryParameters);

		$this->seeInDatabase('categories', array_merge([
			'fair_id' => $fair->id
		], $categoryParameters));
	}

	/** @test */
	public function it_creates_fair_event()
	{
		$user = User::create([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		]);

		$eventType = EventType::create([
			'name' => 'foo'
		]);

		$fair = Fair::create([
			'name' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'website' => 'qux',
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now(),
			'address' => 'foo-bar',
			'latitude' => 9.9,
			'longitude' => 8.8,
			'user_id' => $user->id
		]);

		$fairEventParameters = [
			'title' => 'fair_event_title',
			'image' => 'fair_event_image',
			'description' => 'fair_event_description',
			'date' => Carbon::now()->addDays(4),
			'location' => 'fair_event_location',
		];

		$this->systemUnderTest->createFairEvent($fair->id, $eventType->id, $fairEventParameters);

		$this->seeInDatabase('fair_events', array_merge([
			'fair_id' => $fair->id,
			'event_type_id' => $eventType->id
		], $fairEventParameters));
	}

	/** @test */
	public function it_creates_map()
	{
		$user = User::create([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		]);

		$fair = Fair::create([
			'name' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'website' => 'qux',
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now(),
			'address' => 'foo-bar',
			'latitude' => 9.9,
			'longitude' => 8.8,
			'user_id' => $user->id
		]);

		$mapParameters = [
			'name' => 'map_name',
			'image' => 'map_image'
		];

		$this->systemUnderTest->createMap($fair->id, $mapParameters);

		$this->seeInDatabase('maps', array_merge([
			'fair_id' => $fair->id
		], $mapParameters));
	}

	/** @test */
	public function it_creates_news()
	{
		$user = User::create([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		]);

		$fair = Fair::create([
			'name' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'website' => 'qux',
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now(),
			'address' => 'foo-bar',
			'latitude' => 9.9,
			'longitude' => 8.8,
			'user_id' => $user->id
		]);

		$newsParameters = [
			'title' => 'news_title',
			'content' => 'news_content',
			'image' => 'news_image'
		];

		$this->systemUnderTest->createNews($fair->id, $newsParameters);

		$this->seeInDatabase('news', array_merge([
			'fair_id' => $fair->id
		], $newsParameters));
	}

	/** @test */
	public function it_creates_speaker()
	{
		$user = User::create([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		]);

		$eventType = EventType::create([
			'name' => 'foo'
		]);

		$fair = Fair::create([
			'name' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'website' => 'qux',
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now(),
			'address' => 'foo-bar',
			'latitude' => 9.9,
			'longitude' => 8.8,
			'user_id' => $user->id
		]);

		$fairEvent = FairEvent::create([
			'title' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'date' => Carbon::now(),
			'location' => 'qux',
			'fair_id' => $fair->id,
			'event_type_id' => $eventType->id
		]);

		$speakerParameters = [
			'name' => 'speaker_name',
			'picture' => 'speaker_image',
			'description' => 'speaker_description'
		];

		$this->systemUnderTest->createSpeaker($fairEvent->id, $speakerParameters);

		$this->seeInDatabase('speakers', array_merge([
			'fair_event_id' => $fairEvent->id
		], $speakerParameters));
	}

	/** @test */
	public function it_creates_sponsor()
	{
		$user = User::create([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		]);

		$sponsorRank = SponsorRank::create([
			'name' => 'foo'
		]);

		$fair = Fair::create([
			'name' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'website' => 'qux',
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now(),
			'address' => 'foo-bar',
			'latitude' => 9.9,
			'longitude' => 8.8,
			'user_id' => $user->id
		]);

		$sponsorParameters = [
			'name' => 'sponsor_name'
		];

		$this->systemUnderTest->createSponsor($fair->id, $sponsorRank->id, $sponsorParameters);

		$this->seeInDatabase('sponsors', array_merge([
			'fair_id' => $fair->id,
			'sponsor_rank_id' => $sponsorRank->id
		], $sponsorParameters));
	}

	/** @test */
	public function it_creates_comment()
	{
		$user = User::create([
			'name' => 'foo',
			'username' => str_random(),
			'email' => str_random(),
			'password' => 'qux'
		]);

		$fair = Fair::create([
			'name' => 'foo',
			'image' => 'bar',
			'description' => 'baz',
			'website' => 'qux',
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now(),
			'address' => 'foo-bar',
			'latitude' => 9.9,
			'longitude' => 8.8,
			'user_id' => $user->id
		]);

		$news = News::create([
			'title' => 'foo',
			'content' => 'bar',
			'image' => 'baz',
			'fair_id' => $fair->id
		]);

		$commentParameters = [
			'text' => 'comment_text'
		];

		$this->systemUnderTest->createComment($news->id, $user->id, $commentParameters);

		$this->seeInDatabase('comments', array_merge([
			'news_id' => $news->id,
			'user_id' => $user->id
		], $commentParameters));
	}
}

/**
 * Class SystemUnderTest
 *
 * Custom implementation to test the DatabaseCreator
 */
class SystemUnderTest
{
	use DatabaseCreator;
}