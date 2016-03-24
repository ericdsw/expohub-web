<?php

use ExpoHub\AccessControllers\FairEventAccessController;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\Repositories\Contracts\FairEventRepository;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class FairEventAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var Mock|FairEventRepository */
	private $fairEventRepository;

	/** @var FairEventAccessController */
	private $fairEventAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->fairEventRepository = $this->mock(FairEventRepository::class);

		$this->fairEventAccessController = new FairEventAccessController($this->jwtAuth, $this->fairEventRepository);
	}

	/** @test */
	public function it_returns_true_if_user_can_create_fair_event_for_fair()
	{
		$fair = new Fair;
		$fair->id = 1;

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([$fair]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->fairEventAccessController->canCreateFairEventForFair($fair->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_create_fair_event_for_fair()
	{
		$fair = new Fair;
		$fair->id = 1;

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->fairEventAccessController->canCreateFairEventForFair($fair->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_fair_event_for_owned_fair()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->id = 1;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([$fair]));
		$user->setRelation('helpingFairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->fairEventRepository->shouldReceive('find')
			->with($fairEvent->id)
			->once()
			->andReturn($fairEvent);

		$result = $this->fairEventAccessController->canUpdateFairEvent($fairEvent->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_fair_event_for_helping_fairs()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->id = 1;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([]));
		$user->setRelation('helpingFairs', collect([$fair]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->fairEventRepository->shouldReceive('find')
			->with($fairEvent->id)
			->once()
			->andReturn($fairEvent);

		$result = $this->fairEventAccessController->canUpdateFairEvent($fairEvent->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_update_fair_event()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->id = 1;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([]));
		$user->setRelation('helpingFairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->fairEventRepository->shouldReceive('find')
			->with($fairEvent->id)
			->once()
			->andReturn($fairEvent);

		$result = $this->fairEventAccessController->canUpdateFairEvent($fairEvent->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_delete_fair_event()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->id = 1;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

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

		$this->fairEventRepository->shouldReceive('find')
			->with($fairEvent->id)
			->once()
			->andReturn($fairEvent);

		$result = $this->fairEventAccessController->canDeleteFairEvent($fairEvent->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_delete_fair_event()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->id = 1;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

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

		$this->fairEventRepository->shouldReceive('find')
			->with($fairEvent->id)
			->once()
			->andReturn($fairEvent);

		$result = $this->fairEventAccessController->canDeleteFairEvent($fairEvent->id);

		$this->assertFalse($result);
	}
}