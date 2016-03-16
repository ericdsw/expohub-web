<?php

use ExpoHub\Repositories\Eloquent\StandRepository;
use ExpoHub\Stand;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StandRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var StandRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new StandRepository(new Stand);
	}

	/** @test */
	public function it_gets_stands_by_fair()
	{
		$user = $this->createUser();
		$fair = $this->createFair($user->id);
		$randomFair = $this->createFair($user->id);

		$this->createStand($fair->id);			// Valid stand
		$this->createStand($fair->id);			// Valid stand
		$this->createStand($randomFair->id);	// Invalid stand, incorrect fair

		$stands = $this->repository->getByFair($fair->id);

		$this->assertCount(2, $stands);
	}
}