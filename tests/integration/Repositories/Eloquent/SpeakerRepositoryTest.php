<?php


use ExpoHub\Repositories\Eloquent\SpeakerRepository;
use ExpoHub\Speaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SpeakerRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var SpeakerRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new SpeakerRepository(new Speaker);
	}

	/** @test */
	public function it_gets_speakers_by_fair_event()
	{
		$user = $this->createUser();
		$fair = $this->createFair($user->id);
		$eventType = $this->createEventType();
		$fairEvent = $this->createFairEvent($fair->id, $eventType->id);
		$randomFairEvent = $this->createFairEvent($fair->id, $eventType->id);

		$this->createSpeaker($fairEvent->id);
		$this->createSpeaker($fairEvent->id);
		$this->createSpeaker($randomFairEvent->id);

		$speakers = $this->repository->getByFairEvents($fairEvent->id);

		$this->assertCount(2, $speakers);
	}
}