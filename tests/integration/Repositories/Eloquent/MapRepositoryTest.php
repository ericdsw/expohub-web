<?php


use ExpoHub\Map;
use ExpoHub\Repositories\Eloquent\MapRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MapRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var MapRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new MapRepository(new Map);
	}

	/** @test */
	public function it_gets_maps_by_fair()
	{
		$user = $this->createUser();
		$fair = $this->createFair($user->id);
		$randomFair = $this->createFair($user->id);

		$this->createMap($fair->id);		// Valid Map
		$this->createMap($fair->id);		// Valid Map
		$this->createMap($randomFair->id);	// Invalid Map, incorrect fair

		$maps = $this->repository->getByFair($fair->id);

		$this->assertCount(2, $maps);
	}
}