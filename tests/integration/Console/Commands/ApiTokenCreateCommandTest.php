<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApiTokenCreateCommandTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function it_creates_api_token()
	{
		$this->artisan('apiToken:create', [
			'name' => 'fooApplication'
		]);

		$this->assertEquals(0, $this->code);

		$this->seeInDatabase('api_tokens', [
			'name' => 'fooApplication'
		]);
	}
}