<?php

use ExpoHub\Sponsor;
use ExpoHub\Transformers\SponsorTransformer;

class SponsorTransformerTest extends TestCase
{
	/** @var SponsorTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new SponsorTransformer;
	}

	/** @test */
	public function it_transforms_sponsor()
	{
		$sponsor = $this->makeSponsor();

		$transformedArray = $this->transformer->transform($sponsor);

		$this->assertEquals([
			'id' => 1,
			'name' => 'sponsor-name',
			'logo' => 'sponsor-logo',
			'slogan' => 'sponsor-slogan',
			'website' => 'sponsor-website'
		], $transformedArray);
	}

	/**
	 * @return Sponsor
	 */
	public function makeSponsor()
	{
		$sponsor = new Sponsor;
		$sponsor->id = 1;
		$sponsor->name = 'sponsor-name';
		$sponsor->logo = 'sponsor-logo';
		$sponsor->slogan = 'sponsor-slogan';
		$sponsor->website = 'sponsor-website';

		return $sponsor;
	}
}