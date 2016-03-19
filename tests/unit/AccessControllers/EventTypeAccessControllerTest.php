<?php

use ExpoHub\AccessControllers\EventTypeAccessController;
use ExpoHub\Constants\UserType;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class EventTypeAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var EventTypeAccessController */
	private $eventTypeAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->eventTypeAccessController = new EventTypeAccessController($this->jwtAuth);
	}

	/** @test */
	public function it_returns_true_for_admin_users_on_can_create()
	{
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_ADMIN;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->eventTypeAccessController->canCreateEventType();

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_for_normal_users_on_can_create()
	{
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_USER;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->eventTypeAccessController->canCreateEventType();

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_for_admin_users_on_can_update()
	{
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_ADMIN;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->eventTypeAccessController->canUpdateEventType();

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_for_normal_users_on_can_update()
	{
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_USER;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->eventTypeAccessController->canUpdateEventType();

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_for_admin_users_on_can_delete()
	{
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_ADMIN;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->eventTypeAccessController->canDeleteEventType();

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_for_normal_users_on_can_delete()
	{
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_USER;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->eventTypeAccessController->canDeleteEventType();

		$this->assertFalse($result);
	}
}