<?php

use ExpoHub\AccessControllers\SponsorAccessController;
use ExpoHub\Fair;
use ExpoHub\Repositories\Contracts\SponsorRepository;
use ExpoHub\Sponsor;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class SponsorAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var Mock|SponsorRepository */
	private $sponsorRepository;

	/** @var SponsorAccessController */
	private $sponsorAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->sponsorRepository = $this->mock(SponsorRepository::class);

		$this->sponsorAccessController = new SponsorAccessController(
			$this->jwtAuth, $this->sponsorRepository
		);
	}

	/** @test */
	public function it_returns_true_if_user_can_create_sponsor_for_fair()
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

		$result = $this->sponsorAccessController->canCreateSponsorForFair($fair->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_create_sponsor_for_fair()
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

		$result = $this->sponsorAccessController->canCreateSponsorForFair($fair->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_sponsor()
	{
		$fair = new Fair;
		$fair->id = 1;

		$sponsor = new Sponsor;
		$sponsor->id = 3;
		$sponsor->fair_id = $fair->id;
		$sponsor->setRelation('fair', $fair);

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([$fair]));

		$this->sponsorRepository->shouldReceive('find')
			->with($sponsor->id)
			->once()
			->andReturn($sponsor);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->sponsorAccessController->canUpdateSponsor($sponsor->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_update_sponsor()
	{
		$fair = new Fair;
		$fair->id = 1;

		$sponsor = new Sponsor;
		$sponsor->id = 3;
		$sponsor->fair_id = $fair->id;
		$sponsor->setRelation('fair', $fair);

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([]));

		$this->sponsorRepository->shouldReceive('find')
			->with($sponsor->id)
			->once()
			->andReturn($sponsor);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->sponsorAccessController->canUpdateSponsor($sponsor->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_delete_sponsor()
	{
		$fair = new Fair;
		$fair->id = 1;

		$sponsor = new Sponsor;
		$sponsor->id = 3;
		$sponsor->fair_id = $fair->id;
		$sponsor->setRelation('fair', $fair);

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([$fair]));

		$this->sponsorRepository->shouldReceive('find')
			->with($sponsor->id)
			->once()
			->andReturn($sponsor);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->sponsorAccessController->canDeleteSponsorRank($sponsor->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_delete_sponsor()
	{
		$fair = new Fair;
		$fair->id = 1;

		$sponsor = new Sponsor;
		$sponsor->id = 3;
		$sponsor->fair_id = $fair->id;
		$sponsor->setRelation('fair', $fair);

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([]));

		$this->sponsorRepository->shouldReceive('find')
			->with($sponsor->id)
			->once()
			->andReturn($sponsor);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->sponsorAccessController->canDeleteSponsorRank($sponsor->id);

		$this->assertFalse($result);
	}
}