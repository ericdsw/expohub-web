<?php

use ExpoHub\Constants\UserType;
use ExpoHub\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminCreateCommandTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function it_creates_a_new_admin_user_without_specifying_a_password()
	{
		$this->artisan('admin:create', [
			'email' 	=> 'mail@mail.com',
			'username' 	=> 'foo'
		]);

		$this->assertEquals(0, $this->code);
		$this->seeInDatabase('users', [
			'name' 		=> 'admin',
			'email'		=> 'mail@mail.com',
			'username' 	=> 'foo',
			'user_type'	=> UserType::TYPE_ADMIN
		]);
		$this->assertTrue(Hash::check('admin', User::where('email', 'mail@mail.com')->first()->password));
	}

	/** @test */
	public function it_creates_a_new_admin_user_with_provided_password()
	{
		$this->artisan('admin:create', [
			'email' 		=> 'mail@mail.com',
			'username' 		=> 'foo',
			'--password' 	=> 'bar'
		]);

		$this->assertEquals(0, $this->code);
		$this->seeInDatabase('users', [
			'name' 		=> 'admin',
			'email'		=> 'mail@mail.com',
			'username' 	=> 'foo',
			'user_type'	=> UserType::TYPE_ADMIN
		]);
		$this->assertTrue(Hash::check('bar', User::where('email', 'mail@mail.com')->first()->password));
	}
}