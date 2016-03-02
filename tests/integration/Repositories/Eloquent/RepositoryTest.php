<?php


use ExpoHub\Repositories\Eloquent\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RepositoryTest extends TestCase
{
	/** @var Mockery\Mock */
	private $modelMock;

	/** @var TestRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->modelMock = $this->mock(Model::class);
		$this->repository = new TestRepository($this->modelMock);
	}

	/** @test */
	public function it_shows_all_resources()
	{
		$eagerLoading = [];
		$collection = new Collection;

		$this->modelMock->shouldReceive('with')
			->with($eagerLoading)
			->once()
			->andReturn($this->modelMock);

		$this->modelMock->shouldReceive('get')
			->withNoArgs()
			->once()
			->andReturn($collection);

		$result = $this->repository->all();

		$this->assertEquals($collection, $result);
	}

	/** @test */
	public function it_finds_a_resource()
	{
		$targetId = 1;
		$eagerLoading = [];
		$returnValue = new stdClass;

		$this->modelMock->shouldReceive('with')
			->with($eagerLoading)
			->once()
			->andReturn($this->modelMock);

		$this->modelMock->shouldReceive('findOrFail')
			->with($targetId)
			->once()
			->andReturn($returnValue);

		$result = $this->repository->find($targetId, $eagerLoading);

		$this->assertEquals($returnValue, $result);
	}

	/** @test */
	public function it_creates_a_resource()
	{
		$createParameters = [];
		$returnValue = new stdClass;

		$this->modelMock->shouldReceive('create')
			->with($createParameters)
			->once()
			->andReturn($returnValue);

		$result = $this->repository->create($createParameters);

		$this->assertEquals($returnValue, $result);
	}

	/** @test */
	public function it_updates_a_resource()
	{
		$targetId = [1];
		$updateParameters = [];
		$returnValue = $this->mock(stdClass::class);

		$this->modelMock->shouldReceive('find')
			->with($targetId)
			->once()
			->andReturn($returnValue);
		
		$returnValue->shouldReceive('update')
			->with($updateParameters)
			->once()
			->andReturn($returnValue);

		$result = $this->repository->update($targetId, $updateParameters);

		$this->assertEquals($returnValue, $result);
	}

	/** @test */
	public function it_deletes_a_resource()
	{
		$targetId = 2;
		$returnValue = 1;

		$this->modelMock->shouldReceive('delete')
			->with($targetId)
			->once()
			->andReturn($returnValue);

		$result = $this->repository->delete($targetId);

		$this->assertEquals($returnValue, $result);
	}
}

class TestRepository extends Repository
{
	// Empty Stub repository
}