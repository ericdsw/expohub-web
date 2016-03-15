<?php
use ExpoHub\Repositories\Contracts\UserRepository;
use ExpoHub\Specifications\UserSpecification;

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
	public function it_creates_user()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'baz'
		];

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

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
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

		$this->post('api/v1/users', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_user()
	{
		$parameters = [
			'name' => 'foo'
		];

		$this->put('api/v1/users/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
	}

	/** @test */
	public function it_wont_update_user_with_invalid_parameters()
	{
		$parameters = [
			// Missing name
		];

		$this->put('api/v1/users/1', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_user()
	{
		$this->delete('api/v1/users/1');
		$this->assertResponseStatus(204);
	}
}