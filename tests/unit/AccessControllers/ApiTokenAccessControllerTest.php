<?php

use ExpoHub\AccessControllers\ApiTokenAccessController;
use ExpoHub\Constants\UserType;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class ApiTokenAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var ApiTokenAccessController */
	private $apiTokenAccessController;

	public function setUp()
	{
		parent::setUp();
		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->apiTokenAccessController = new ApiTokenAccessController($this->jwtAuth);
	}

	/** @test */
	public function it_returns_true_for_admin_users_on_can_list()
	{
		$user = new User;
		$user->user_type = UserType::TYPE_ADMIN;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->apiTokenAccessController->canListApiTokens();

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_for_non_admin_users_on_can_list()
	{
		$user = new User;
		$user->user_type = UserType::TYPE_USER;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->apiTokenAccessController->canListApiTokens();

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_for_admin_users_on_can_show()
	{
		$user = new User;
		$user->user_type = UserType::TYPE_ADMIN;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->apiTokenAccessController->canShowApiToken();

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_for_non_admin_users_on_can_show()
	{
		$user = new User;
		$user->user_type = UserType::TYPE_USER;

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->apiTokenAccessController->canShowApiToken();

		$this->assertFalse($result);
	}
}