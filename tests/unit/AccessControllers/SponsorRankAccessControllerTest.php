<?php

use ExpoHub\AccessControllers\SponsorRankAccessController;
use ExpoHub\Constants\UserType;
use ExpoHub\User;
use Tymon\JWTAuth\JWTAuth;

class SponsorRankAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var SponsorRankAccessController */
	private $sponsorRankAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->sponsorRankAccessController = new SponsorRankAccessController($this->jwtAuth);
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

		$result = $this->sponsorRankAccessController->canCreateSponsorRank();

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

		$result = $this->sponsorRankAccessController->canCreateSponsorRank();

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

		$result = $this->sponsorRankAccessController->canUpdateSponsorRank();

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

		$result = $this->sponsorRankAccessController->canUpdateSponsorRank();

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

		$result = $this->sponsorRankAccessController->canDeleteSponsorRank();

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

		$result = $this->sponsorRankAccessController->canDeleteSponsorRank();

		$this->assertFalse($result);
	}
}