<?php

use ExpoHub\AccessControllers\FairAccessController;
use ExpoHub\Fair;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class FairAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var FairAccessController */
	private $fairAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->fairAccessController = new FairAccessController($this->jwtAuth);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_fair()
	{
		$fair = new Fair;
		$fair->id = 2;

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

		$result = $this->fairAccessController->canUpdateFair($fair->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_update_fair()
	{
		$fair = new Fair;
		$fair->id = 2;

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

		$result = $this->fairAccessController->canUpdateFair($fair->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_delete_fair()
	{
		$fair = new Fair;
		$fair->id = 2;

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

		$result = $this->fairAccessController->canDeleteFair($fair->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_delete_fair()
	{
		$fair = new Fair;
		$fair->id = 2;

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

		$result = $this->fairAccessController->canDeleteFair($fair->id);

		$this->assertFalse($result);
	}
}