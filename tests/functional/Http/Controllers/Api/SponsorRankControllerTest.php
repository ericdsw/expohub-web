<?php

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

		$this->post('api/v1/sponsorRanks', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor-rank']);
	}

	/** @test */
	public function it_wont_create_sponsor_rank_with_invalid_parameters()
	{
		$parameters = [
			// No name
		];

		$this->post('api/v1/sponsorRanks', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_sponsor_rank()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->put('api/v1/sponsorRanks/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor-rank']);
	}

	/** @test */
	public function it_wont_update_sponsor_rank_with_invalid_parameters()
	{
		$parameters = [
			// No name
		];

		$this->put('api/v1/sponsorRanks/1', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_sponsor_rank()
	{
		$this->delete('api/v1/sponsorRanks/1');

		$this->assertResponseStatus(204);
	}
}