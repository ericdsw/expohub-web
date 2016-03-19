<?php

use ExpoHub\AccessControllers\UserAccessController;
use ExpoHub\Constants\UserType;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class UserAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var UserAccessController */
	private $userAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->userAccessController = new UserAccessController($this->jwtAuth);
	}

	/** @test */
	public function it_returns_true_for_admins_on_can_create()
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

		$result = $this->userAccessController->canCreateUser();

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_for_non_admins_on_can_create()
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

		$result = $this->userAccessController->canCreateUser();

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_for_admins_on_can_update()
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

		$result = $this->userAccessController->canUpdateUser();

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_for_non_admins_on_can_update()
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

		$result = $this->userAccessController->canUpdateUser();

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_for_admins_on_can_delete()
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

		$result = $this->userAccessController->canDeleteUser();

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_for_non_admins_on_can_delete()
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

		$result = $this->userAccessController->canDeleteUser();

		$this->assertFalse($result);
	}
}