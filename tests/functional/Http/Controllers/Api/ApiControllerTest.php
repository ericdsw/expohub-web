<?php

use ExpoHub\Repositories\Contracts\UserRepository;
use ExpoHub\Specifications\UserSpecification;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class ApiControllerTest extends BaseControllerTestCase
{
	/** @var Mock */
	private $userSpecification;

	public function setUp()
	{
		parent::setUp();

		$this->userSpecification = $this->mock(UserSpecification::class);

		app()->instance(UserRepository::class, new StubUserRepository);
	}

	/** @test */
	public function it_logins_user()
	{
		$parameters = [
			'login_param' 	=> 'foo',
			'password' 		=> 'bar'
		];

		$token = 'baz';
		$user = new User;

		$this->jwtAuth->shouldReceive('attempt')
			->with([
				'username' => 'foo',
				'password' => 'bar'
			])->once()
			->andReturn($token);

		$this->jwtAuth->shouldReceive('toUser')
			->with($token)
			->once()
			->andReturn($user);

		$this->post('api/v1/login', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
		$this->seeJsonContains(['token' => $token]);
	}

	/** @test */
	public function it_wont_login_user_with_invalid_credentials()
	{
		$parameters = [
			'login_param' 	=> 'foo',
			'password' 		=> 'bar'
		];

		$this->jwtAuth->shouldReceive('attempt')
			->with([
				'username' => 'foo',
				'password' => 'bar'
			])->once()
			->andReturn(false);


		$this->post('api/v1/login', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_login_user_when_auth_error_occurs()
	{
		$parameters = [
			'login_param' 	=> 'foo',
			'password' 		=> 'bar'
		];

		$this->jwtAuth->shouldReceive('attempt')
			->with([
				'username' => 'foo',
				'password' => 'bar'
			])->once()
			->andThrow(JWTException::class);


		$this->post('api/v1/login', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_login_user_with_invalid_parameters()
	{
		$parameters = [
			// Missing login param
			'password' 		=> 'bar'
		];

		$this->post('api/v1/login', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_registers_user()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'qux'
		];

		$token = "fooBar";

		$this->userSpecification->shouldReceive('isEmailAvailable')
			->with('baz@mail.com')
			->once()
			->andReturn(true);

		$this->userSpecification->shouldReceive('isUsernameAvailable')
			->with('bar')
			->once()
			->andReturn(true);

		$this->jwtAuth->shouldReceive('fromUser')
			->withAnyArgs()
			->once()
			->andReturn($token);

		$this->post('api/v1/register', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'user']);
		$this->seeJsonContains(['token' => $token]);
	}

	/** @test */
	public function it_wont_register_user_if_email_already_exists()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'qux'
		];

		$this->userSpecification->shouldReceive('isEmailAvailable')
			->with('baz@mail.com')
			->once()
			->andReturn(false);


		$this->post('api/v1/register', $parameters);

		$this->assertResponseStatus(409);
	}

	/** @test */
	public function it_wont_register_user_if_username_already_exists()
	{
		$parameters = [
			'name' => 'foo',
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'qux'
		];

		$this->userSpecification->shouldReceive('isEmailAvailable')
			->with('baz@mail.com')
			->once()
			->andReturn(true);

		$this->userSpecification->shouldReceive('isUsernameAvailable')
			->with('bar')
			->once()
			->andReturn(false);

		$this->post('api/v1/register', $parameters);

		$this->assertResponseStatus(409);
	}

	/** @test */
	public function it_wont_register_user_with_invalid_parameters()
	{
		$parameters = [
			// Missing name
			'username' => 'bar',
			'email' => 'baz@mail.com',
			'password' => 'qux'
		];

		$this->post('api/v1/register', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_logout_user()
	{
		$this->loginForApi();

		$this->jwtAuth->shouldReceive('invalidate')
			->withAnyArgs()
			->once();

		$this->post('api/v1/logout');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_wont_logout_non_logged_in_users()
	{
		$this->post('api/v1/logout');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_logout_users_with_invalid_token()
	{
		$this->loginForApiWithExpiredToken();

		$this->post('api/v1/logout');

		$this->assertResponseStatus(401);
	}
}