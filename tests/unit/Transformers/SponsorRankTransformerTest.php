<?php

use ExpoHub\SponsorRank;
use ExpoHub\Transformers\SponsorRankTransformer;

class SponsorRankTransformerTest extends TestCase
{
	/** @var SponsorRankTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new SponsorRankTransformer;
	}

	/** @test */
	public function it_transforms_sponsor_rank()
	{
		$sponsorRank = $this->makeSponsorRank();

		$transformedArray = $this->transformer->transform($sponsorRank);

		$this->assertEquals([
			'id' => 1,
			'name' => 'sponsor-rank-name'
		], $transformedArray);
	}

	/**
	 * @return SponsorRank
	 */
	private function makeSponsorRank()
	{
		$sponsorRank = new SponsorRank;
		$sponsorRank->id = 1;
		$sponsorRank->name = 'sponsor-rank-name';

		return $sponsorRank;
	}
}