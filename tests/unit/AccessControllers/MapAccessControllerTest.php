<?php

use ExpoHub\AccessControllers\MapAccessController;
use ExpoHub\Fair;
use ExpoHub\Map;
use ExpoHub\Repositories\Contracts\MapRepository;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class MapAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var Mock|MapRepository */
	private $mapRepository;

	/** @var MapAccessController */
	private $mapAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->mapRepository = $this->mock(MapRepository::class);

		$this->mapAccessController = new MapAccessController($this->jwtAuth, $this->mapRepository);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_map()
	{
		$fair = new Fair;
		$fair->id = 1;

		$map = new Map;
		$map->id = 1;
		$map->fair_id = $fair->id;
		$map->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([$fair]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->mapRepository->shouldReceive('find')
			->with($map->id)
			->once()
			->andReturn($map);

		$result = $this->mapAccessController->canUpdateMap($map->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_udpate_map()
	{
		$fair = new Fair;
		$fair->id = 1;

		$map = new Map;
		$map->id = 1;
		$map->fair_id = $fair->id;
		$map->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->mapRepository->shouldReceive('find')
			->with($map->id)
			->once()
			->andReturn($map);

		$result = $this->mapAccessController->canUpdateMap($map->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_delete_map()
	{
		$fair = new Fair;
		$fair->id = 1;

		$map = new Map;
		$map->id = 1;
		$map->fair_id = $fair->id;
		$map->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([$fair]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->mapRepository->shouldReceive('find')
			->with($map->id)
			->once()
			->andReturn($map);

		$result = $this->mapAccessController->canDeleteMap($map->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_delete_map()
	{
		$fair = new Fair;
		$fair->id = 1;

		$map = new Map;
		$map->id = 1;
		$map->fair_id = $fair->id;
		$map->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->mapRepository->shouldReceive('find')
			->with($map->id)
			->once()
			->andReturn($map);

		$result = $this->mapAccessController->canDeleteMap($map->id);

		$this->assertFalse($result);
	}
}