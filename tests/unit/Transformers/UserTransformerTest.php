<?php

use ExpoHub\Transformers\UserTransformer;
use ExpoHub\User;

class UserTransformerTest extends TestCase
{
	/** @var UserTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new UserTransformer;
	}

	/** @test */
	public function it_transforms_user()
	{
		$user = $this->makeUser();

		$transformedArray = $this->transformer->transform($user);

		$this->assertEquals([
			'id' => 1,
			'name' => 'user-name',
			'username' => 'user-username',
			'email' => 'user-email'
		], $transformedArray);
	}

	/**
	 * @return User
	 */
	private function makeUser()
	{
		$user = new User;
		$user->id = 1;
		$user->name = 'user-name';
		$user->username = 'user-username';
		$user->email = 'user-email';

		return $user;
	}
}