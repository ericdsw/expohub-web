<?php

use ExpoHub\Repositories\Eloquent\UserRepository;
use ExpoHub\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserRepositoryTest extends BaseControllerTestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var UserRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new UserRepository(new User);
	}

	/** @test */
	public function it_gets_user_by_username()
	{
		$expectedUser = $this->createUser(['username' => 'fooUsername']);
		$this->createUser(['username' => 'randomUsername']);
		$this->createUser(['username' => 'randomUsername2']);

		$user = $this->repository->getByUsername('fooUsername');

		$this->assertNotNull($user);
		$this->assertEquals($expectedUser->id, $user->id);
	}

	/** @test */
	public function it_gets_user_by_email()
	{
		$expectedUser = $this->createUser(['email' => 'fooEmail']);
		$this->createUser(['email' => 'randomEmail']);
		$this->createUser(['email' => 'randomEmail2']);

		$user = $this->repository->getByEmail('fooEmail');

		$this->assertNotNull($user);
		$this->assertEquals($expectedUser->id, $user->id);
	}
}