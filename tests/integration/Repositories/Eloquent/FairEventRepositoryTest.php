<?php

use ExpoHub\FairEvent;
use ExpoHub\Repositories\Eloquent\FairEventRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FairEventRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var FairEventRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new FairEventRepository(new FairEvent);
	}

	/** @test */
	public function it_gets_fair_events_by_fair()
	{
		$user 		= $this->createUser();
		$fair 		= $this->createFair($user->id);
		$randomFair = $this->createFair($user->id);
		$eventType 	= $this->createEventType();

		$this->createFairEvent($fair->id, $eventType->id);			// Valid FairEvent
		$this->createFairEvent($fair->id, $eventType->id);			// Valid FairEvent
		$this->createFairEvent($randomFair->id, $eventType->id);	// Invalid FairEvent, incorrect fair

		$fairEvents = $this->repository->getByFair($fair->id);

		$this->assertCount(2, $fairEvents);
	}

	/** @test */
	public function it_gets_fair_events_by_event_type()
	{
		$user 				= $this->createUser();
		$fair 				= $this->createFair($user->id);
		$eventType			= $this->createEventType();
		$randomEventType 	= $this->createEventType();

		$this->createFairEvent($fair->id, $eventType->id);			// Valid FairEvent
		$this->createFairEvent($fair->id, $eventType->id);			// Valid FairEvent
		$this->createFairEvent($fair->id, $randomEventType->id);	// Invalid FairEvent, incorrect event type

		$fairEvents = $this->repository->getByEventType($eventType->id);

		$this->assertCount(2, $fairEvents);
	}

	/** @test */
	public function it_gets_fair_events_by_attending_users()
	{
		$user 			= $this->createUser();
		$fair 			= $this->createFair($user->id);
		$eventType 		= $this->createEventType();
		$attendingUser 	= $this->createUser();

		$firstFair 	= $this->createFairEvent($fair->id, $eventType->id);
		$secondFair = $this->createFairEvent($fair->id, $eventType->id);
		$thirdFair 	= $this->createFairEvent($fair->id, $eventType->id);

		$firstFair->attendingUsers()->attach($attendingUser->id);
		$secondFair->attendingUsers()->attach($attendingUser->id);

		$fairEvents = $this->repository->getByAttendingUser($attendingUser->id);

		$this->assertCount(2, $fairEvents);
	}

	/** @test */
	public function it_gets_fair_events_by_categories()
	{
		$user 		= $this->createUser();
		$fair 		= $this->createFair($user->id);
		$eventType 	= $this->createEventType();

		$firstCategory 		= $this->createCategory($fair->id);
		$secondCategory 	= $this->createCategory($fair->id);
		$thirdCategory 		= $this->createCategory($fair->id);
		$fourthCategory 	= $this->createCategory($fair->id);

		$firstFairEvent 	= $this->createFairEvent($fair->id, $eventType->id);
		$secondFairEvent 	= $this->createFairEvent($fair->id, $eventType->id);
		$thirdFairEvent 	= $this->createFairEvent($fair->id, $eventType->id);
		$fourthFairEvent 	= $this->createFairEvent($fair->id, $eventType->id);

		$firstFairEvent->categories()->attach($firstCategory->id);
		$firstFairEvent->categories()->attach($secondCategory->id);
		$secondFairEvent->categories()->attach($firstCategory->id);
		$thirdFairEvent->categories()->attach($thirdCategory->id);
		$thirdFairEvent->categories()->attach($fourthCategory->id);
		$fourthFairEvent->categories()->attach($secondCategory->id);

		$fairEvents = $this->repository->getByCategories([$firstCategory->id, $secondCategory->id]);

		$this->assertCount(3, $fairEvents);
	}

	/** @test */
	public function it_attends_fair_event()
	{
		$creatingUser 	= $this->createUser();
		$attendingUser	= $this->createUser();
		$fair 			= $this->createFair($creatingUser->id);
		$category 		= $this->createCategory($fair->id);
		$fairEvent 		= $this->createFairEvent($fair->id, $category->id);

		$this->repository->attendEvent($attendingUser->id, $fairEvent->id);

		$this->assertCount(1, $fairEvent->attendingUsers);
		$this->assertEquals(1, $fairEvent->fresh()->attendance);
	}

	/** @test */
	public function it_un_attends_fair_event()
	{
		$creatingUser 	= $this->createUser();
		$attendingUser	= $this->createUser();
		$fair 			= $this->createFair($creatingUser->id);
		$category 		= $this->createCategory($fair->id);
		$fairEvent 		= $this->createFairEvent($fair->id, $category->id, ['attendance' => 1]);

		$fairEvent->attendingUsers()->attach($attendingUser->id);

		$this->repository->unAttendEvent($attendingUser->id, $fairEvent->id);

		$this->assertCount(0, $fairEvent->attendingUsers);
		$this->assertEquals(0, $fairEvent->fresh()->attendance);
	}
}
