<?php

use ExpoHub\Helpers\Generators\DateNameGenerator;

class DateNameGeneratorTest extends TestCase
{
	/** @var DateNameGenerator */
	private $dateNameGenerator;

	public function setUp()
	{
		parent::setUp();
		$this->dateNameGenerator = new DateNameGenerator;
	}

	/** @test */
	public function it_generates_random_name_with_correct_extension()
	{
		$extension = 'jpg';

		$result = $this->dateNameGenerator->generateUniqueName($extension);

		$this->assertEquals($extension, explode('.', $result)[1]);
	}
}