<?php

use ExpoHub\Helpers\Credentials\CredentialsHelper;

class CredentialsHelperTest extends TestCase
{
	/** @var CredentialsHelper */
	private $credentialsHelper;

	public function setUp()
	{
		parent::setUp();
		$this->credentialsHelper = new CredentialsHelper();
	}

	/** @test */
	public function it_detects_if_parameter_is_email()
	{
		$result = $this->credentialsHelper->getLoginField('foo@mail.com');

		$this->assertEquals($result, 'email');
	}

	/** @test */
	public function it_detects_if_parameter_is_username()
	{
		$result = $this->credentialsHelper->getLoginField('bar');

		$this->assertEquals($result, 'username');
	}
}