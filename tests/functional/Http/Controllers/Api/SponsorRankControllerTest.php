<?php

use ExpoHub\AccessControllers\SponsorRankAccessController;
use ExpoHub\Repositories\Contracts\SponsorRankRepository;

class SponsorRankControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(SponsorRankRepository::class, new StubSponsorRankRepository);
	}

	/** @test */
	public function it_displays_all_sponsor_ranks()
	{
		$this->get('api/v1/sponsorRanks');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor-rank']);
	}

	/** @test */
	public function it_displays_specific_sponsor_rank()
	{
		$this->get('api/v1/sponsorRanks/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor-rank']);
	}

	/** @test */
	public function it_displays_specific_sponsor_rank_with_includes()
	{
		$includeString = 'sponsors';
		$this->get('api/v1/sponsorRanks/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor-rank']);
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_creates_sponsor_rank()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApi();

		$this->mock(SponsorRankAccessController::class)
			->shouldReceive('canCreateSponsorRank')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->post('api/v1/sponsorRanks', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor-rank']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_create_sponsor_rank()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApi();

		$this->mock(SponsorRankAccessController::class)
			->shouldReceive('canCreateSponsorRank')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->post('api/v1/sponsorRanks', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_sponsor_rank_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->post('api/v1/sponsorRanks', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_sponsor_rank_if_user_has_expired_session()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApiWithExpiredToken();

		$this->post('api/v1/sponsorRanks', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_wont_create_sponsor_rank_with_invalid_parameters()
	{
		$parameters = [
			// No name
		];

		$this->loginForApi();

		$this->mock(SponsorRankAccessController::class)
			->shouldReceive('canCreateSponsorRank')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->post('api/v1/sponsorRanks', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_sponsor_rank()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApi();

		$this->mock(SponsorRankAccessController::class)
			->shouldReceive('canUpdateSponsorRank')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->put('api/v1/sponsorRanks/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor-rank']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_update_sponsor_rank()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApi();

		$this->mock(SponsorRankAccessController::class)
			->shouldReceive('canUpdateSponsorRank')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->put('api/v1/sponsorRanks/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_sponsor_rank_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->put('api/v1/sponsorRanks/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_sponsor_rank_if_user_has_expired_session()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApiWithExpiredToken();

		$this->put('api/v1/sponsorRanks/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_wont_update_sponsor_rank_with_invalid_parameters()
	{
		$parameters = [
			// No name
		];

		$this->loginForApi();

		$this->mock(SponsorRankAccessController::class)
			->shouldReceive('canUpdateSponsorRank')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->put('api/v1/sponsorRanks/1', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_sponsor_rank()
	{
		$this->loginForApi();

		$this->mock(SponsorRankAccessController::class)
			->shouldReceive('canDeleteSponsorRank')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->delete('api/v1/sponsorRanks/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_delete_sponsor_rank()
	{
		$this->loginForApi();

		$this->mock(SponsorRankAccessController::class)
			->shouldReceive('canDeleteSponsorRank')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->delete('api/v1/sponsorRanks/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_sponsor_rank_if_user_is_not_logged_in()
	{
		$this->delete('api/v1/sponsorRanks/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_sponsor_rank_if_user_has_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/sponsorRanks/1');

		$this->assertResponseStatus(401);
	}
}