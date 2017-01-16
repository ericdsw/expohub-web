<?php

use ExpoHub\Helpers\Generators\JsonErrorGenerator;
use ExpoHub\JsonError;

class JsonErrorGeneratorTest extends TestCase 
{
	/** @var JsonErrorGenerator */
	private $jsonErrorGenerator;

	public function setUp() 
	{
		parent::setUp();
		$this->jsonErrorGenerator = new JsonErrorGenerator;
	}

	/** @test */
	public function it_generates_correct_response_with_several_api_errors()
	{
		$this->jsonErrorGenerator->setStatus(412)
			->appendError(new JsonError("title1", "detail1", "412", "code1"))
			->appendError(new JsonError("title2", "detail2", "412", "code2"))
			->appendError(new JsonError("title3", "detail3", "412", "code3"));

		$response = $this->jsonErrorGenerator->generateErrorResponse();

		$expected = json_encode([
			'errors' => [
				[
					'title' 	=> 'title1',
					'detail' 	=> 'detail1',
					'status' 	=> '412',
					'code' 		=> 'code1'
				],
				[
					'title' 	=> 'title2',
					'detail' 	=> 'detail2',
					'status' 	=> '412',
					'code' 		=> 'code2'
				],
				[
					'title' 	=> 'title3',
					'detail' 	=> 'detail3',
					'status' 	=> '412',
					'code' 		=> 'code3'
				]
			]
		]);

		$this->assertEquals($expected, json_encode($response->getOriginalContent()));
	}

	/** @test */
	public function it_generates_correct_response_with_one_api_error() 
	{
		$this->jsonErrorGenerator->setStatus(412)
			->appendError(new JsonError("title1", "detail1", "412", "code1"));

		$response = $this->jsonErrorGenerator->generateErrorResponse();

		$expected = json_encode([
			'errors' => [
				[
					'title' 	=> 'title1',
					'detail' 	=> 'detail1',
					'status' 	=> '412',
					'code' 		=> 'code1'
				]
			]
		]);

		$this->assertEquals($expected, json_encode($response->getOriginalContent()));
	}

	/** @test */
	public function it_generates_correct_json_with_api_errors() 
	{
		$this->jsonErrorGenerator->setStatus(412)
			->appendError(new JsonError("title1", "detail1", "412", "code1"));

		$jsonRepresentation = $this->jsonErrorGenerator->generateErrorJson();

		$expected = json_encode([
			'errors' => [
				[
					'title' 	=> 'title1',
					'detail' 	=> 'detail1',
					'status' 	=> '412',
					'code' 		=> 'code1'
				]
			]
		]);

		$this->assertEquals($expected, json_encode($jsonRepresentation));
	}
}
