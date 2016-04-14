<?php

use ExpoHub\Constants\UserType;
use ExpoHub\Repositories\Contracts\ApiTokenRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiTokenControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(ApiTokenRepository::class, new StubApiTokenRepository);
	}

	/** @test */
	public function it_displays_a_list_of_api_tokens_for_admins()
	{
		$loggedUser = $this->loginForApi();
		$loggedUser->user_type = UserType::TYPE_ADMIN;

		$this->get('api/v1/apiTokens');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'apiTokens']);
	}

	/** @test */
	public function it_wont_display_list_of_api_tokens_for_non_admins()
	{
		$loggedUser = $this->loginForApi();
		$loggedUser->user_type = UserType::TYPE_USER;

		$this->get('api/v1/apiTokens');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_display_list_of_api_tokens_for_not_logged_in_users()
	{
		$this->get('api/v1/apiTokens');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_display_list_of_api_tokens_for_users_with_expired_sessions()
	{
		$this->loginForApiWithExpiredToken();

		$this->get('api/v1/apiTokens');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_displays_specific_api_token_for_admins()
	{
		$loggedUser = $this->loginForApi();
		$loggedUser->user_type = UserType::TYPE_ADMIN;

		$this->get('api/v1/apiTokens/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'apiTokens']);
	}

	/** @test */
	public function it_wont_display_specific_api_token_for_non_admins()
	{
		$loggedUser = $this->loginForApi();
		$loggedUser->user_type = UserType::TYPE_USER;

		$this->get('api/v1/apiTokens/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_display_specific_api_token_for_not_logged_in_users()
	{
		$this->get('api/v1/apiTokens/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_display_specific_api_token_for_users_with_expired_sessions()
	{
		$this->loginForApiWithExpiredToken();

		$this->get('api/v1/apiTokens/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_returns_not_found_if_api_token_does_not_exists_for_admins()
	{
		$loggedUser = $this->loginForApi();
		$loggedUser->user_type = UserType::TYPE_ADMIN;

		$this->mock(ApiTokenRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/apiTokens/1');

		$this->assertResponseStatus(404);
	}
}