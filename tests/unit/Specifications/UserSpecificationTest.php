<?php

use ExpoHub\Repositories\Contracts\UserRepository;
use ExpoHub\Specifications\UserSpecification;
use ExpoHub\User;

class UserSpecificationTest extends TestCase
{
	/** @var UserSpecification */
	private $specification;

	/** @var Mockery\Mock|UserRepository */
	private $userRepository;

	public function setUp()
	{
		parent::setUp();
		$this->userRepository = $this->mock(UserRepository::class);
		$this->specification = new UserSpecification($this->userRepository);
	}

	/** @test */
	public function it_returns_true_if_email_is_available()
	{
		$email = "foo";
		$this->userRepository->shouldReceive('getByEmail')
			->with($email)
			->once()
			->andReturn(null);

		$result = $this->specification->isEmailAvailable($email);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_email_is_not_available()
	{
		$email = "foo";
		$user = new User();

		$this->userRepository->shouldReceive('getByEmail')
			->with($email)
			->once()
			->andReturn($user);

		$result = $this->specification->isEmailAvailable($email);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_username_is_available()
	{
		$username = "foo";
		$this->userRepository->shouldReceive('getByUsername')
			->with($username)
			->once()
			->andReturn(null);

		$result = $this->specification->isUsernameAvailable($username);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_username_is_not_available()
	{
		$username = "foo";
		$user = new User;
		$this->userRepository->shouldReceive('getByUsername')
			->with($username)
			->once()
			->andReturn($user);

		$result = $this->specification->isUsernameAvailable($username);

		$this->assertFalse($result);
	}
}