<?php
use ExpoHub\AccessControllers\UserAccessController;
use ExpoHub\Repositories\Contracts\UserRepository;
use ExpoHub\Specifications\UserSpecification;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(UserRepository::class, new StubUserRepository);
	}

	/** @test */
	public function it_displays_a_list_of_users()
	{
		$this->get('api/v1/users');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
	}

	/** @test */
	public function it_displays_specific_list_of_users()
	{
		$this->get('api/v1/users/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
	}

	/** @test */
	public function it_displays_specific_list_of_users_with_available_includes()
	{
		$includeString = "fairs,bannedFairs,helpingFairs,attendingFairEvents,comments";

		$this->get('api/v1/users/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
		$this->seeJsonContains(['type' => 'fair']);
		$this->seeJsonContains(['type' => 'fair-event']);
		$this->seeJsonContains(['type' => 'comment']);
	}

	/** @test */
	public function it_returns_not_found_if_user_does_not_exists()
	{
		$this->mock(UserRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/users/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_user()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'baz'
		];

		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canCreateUser')
			->withNoArgs()
			->once()
			->andReturn(true);

		$userSpecification = $this->mock(UserSpecification::class);

		$userSpecification->shouldReceive('isEmailAvailable')
			->with('baz@mail.com')
			->once()
			->andReturn(true);

		$userSpecification->shouldReceive('isUsernameAvailable')
			->with('bar')
			->once()
			->andReturn(true);

		$this->post('api/v1/users', $parameters);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_create_users()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'baz'
		];

		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canCreateUser')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->post('api/v1/users', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_user_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'baz'
		];

		$this->post('api/v1/users', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_user_if_user_has_expired_token()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'baz'
		];

		$this->loginForApiWithExpiredToken();

		$this->post('api/v1/users', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_wont_create_user_with_existing_email()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'baz'
		];

		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canCreateUser')
			->withNoArgs()
			->once()
			->andReturn(true);

		$userSpecification = $this->mock(UserSpecification::class);

		$userSpecification->shouldReceive('isEmailAvailable')
			->with('baz@mail.com')
			->once()
			->andReturn(false);

		$this->post('api/v1/users', $parameters);

		$this->assertResponseStatus(409);
	}

	/** @test */
	public function it_wont_create_user_with_existing_username()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'baz'
		];

		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canCreateUser')
			->withNoArgs()
			->once()
			->andReturn(true);

		$userSpecification = $this->mock(UserSpecification::class);

		$userSpecification->shouldReceive('isEmailAvailable')
			->with('baz@mail.com')
			->once()
			->andReturn(true);

		$userSpecification->shouldReceive('isUsernameAvailable')
			->with('bar')
			->once()
			->andReturn(false);

		$this->post('api/v1/users', $parameters);

		$this->assertResponseStatus(409);
	}

	/** @test */
	public function it_wont_create_user_with_invalid_parameters()
	{
		$parameters = [
			// Missing name
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'baz'
		];

		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canCreateUser')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->post('api/v1/users', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_user()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canUpdateUser')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->put('api/v1/users/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_update_user()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canUpdateUser')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->put('api/v1/users/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_user_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->put('api/v1/users/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_user_if_user_has_expired_session()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->loginForApiWithExpiredToken();

		$this->put('api/v1/users/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_wont_update_user_with_invalid_parameters()
	{
		$parameters = [
			// Missing name
		];

		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canUpdateUser')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->put('api/v1/users/1', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_user()
	{
		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canDeleteUser')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->delete('api/v1/users/1');
		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_delete_user()
	{
		$this->loginForApi();

		$this->mock(UserAccessController::class)
			->shouldReceive('canDeleteUser')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->delete('api/v1/users/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_user_if_user_is_not_logged_in()
	{
		$this->delete('api/v1/users/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_user_if_user_has_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/users/1');

		$this->assertResponseStatus(401);
	}
}