<?php

use ExpoHub\ApiToken;
use ExpoHub\Repositories\Eloquent\ApiTokenRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApiTokenRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var ApiTokenRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new ApiTokenRepository(new ApiToken);
	}

	/** @test */
	public function it_gets_api_token_by_app_id_and_secret()
	{
		$this->createApiToken([
			'app_id' => 'fooAppId',
			'app_secret' => 'fooAppSecret'
		]);

		$apiToken = $this->repository->getByTokenAndSecret('fooAppId', 'fooAppSecret');

		$this->assertNotNull($apiToken);
	}

	/** @test */
	public function it_gets_api_token_by_app_id()
	{
		$this->createApiToken([
			'app_id' => 'fooAppId',
			'app_secret' => 'fooAppSecret'
		]);

		$apiToken = $this->repository->getByToken('fooAppId');

		$this->assertNotNull($apiToken);
	}
}
