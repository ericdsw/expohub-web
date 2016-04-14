<?php

use ExpoHub\AccessControllers\ApiAccessController;
use ExpoHub\ApiToken;
use ExpoHub\Repositories\Contracts\ApiTokenRepository;
use Mockery\Mock;

class ApiAccessControllerTest extends TestCase
{
	/** @var Mock|ApiTokenRepository */
	private $apiTokenRepository;

	/** @var ApiAccessController */
	private $apiAccessController;

	public function setUp()
	{
		parent::setUp();
		$this->apiTokenRepository  = $this->mock(ApiTokenRepository::class);
		$this->apiAccessController = new ApiAccessController($this->apiTokenRepository);
	}

	/** @test */
	public function it_returns_true_if_user_can_access_api()
	{
		$apiToken 	= new ApiToken;
		$appId 		= 'foo';
		$appSecret 	= 'bar';

		$this->apiTokenRepository->shouldReceive('getByTokenAndSecret')
			->with($appId, $appSecret)
			->once()
			->andReturn($apiToken);

		$header = ['x-api-authorization' => $appId . '.' . $appSecret];

		$result = $this->apiAccessController->canUseApi($header);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_access_api()
	{
		$appId 		= 'foo';
		$appSecret 	= 'bar';

		$this->apiTokenRepository->shouldReceive('getByTokenAndSecret')
			->with($appId, $appSecret)
			->once()
			->andReturn(null);

		$header = ['x-api-authorization' => $appId . '.' . $appSecret];

		$result = $this->apiAccessController->canUseApi($header);

		$this->assertFalse($result);
	}

	/**
	 * @test
	 * @expectedException ExpoHub\Exceptions\NoApiAccessTokenException
	 */
	public function it_throws_exception_if_api_token_is_not_provided()
	{
		$header = [];

		$this->apiAccessController->canUseApi($header);
	}

	/**
	 * @test
	 * @expectedException ExpoHub\Exceptions\MalformedApiAccessTokenException
	 */
	public function it_throws_exception_if_api_token_is_malformed()
	{
		$header = ['x-api-authorization' => 'foo'];

		$this->apiAccessController->canUseApi($header);
	}
}