<?php

use ExpoHub\ApiToken;
use ExpoHub\Transformers\ApiTokenTransformer;

class ApiTokenTransformerTest extends TestCase
{
	/** @var ApiTokenTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new ApiTokenTransformer;
	}

	/** @test */
	public function it_transforms_api_token()
	{
		$apiToken = $this->makeApiToken();

		$result = $this->transformer->transform($apiToken);

		$this->assertEquals([
			'id' => 1,
			'name' => 'foo',
			'app_id' => 'app_id',
			'app_secret' => 'app_secret',
		], $result);
	}

	private function makeApiToken()
	{
		$apiToken = new ApiToken;
		$apiToken->id = 1;
		$apiToken->app_id = 'app_id';
		$apiToken->app_secret = 'app_secret';
		$apiToken->name = 'foo';

		return $apiToken;
	}
}