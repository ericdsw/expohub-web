<?php


use Mockery\Mock;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class BaseControllerTestCase extends TestCase
{
	public function authenticate()
	{
		// Auth implementation
	}

	/**
	 * @return Mock
	 */
	protected function generateStubUploadedFile()
	{
		return $this->mock(UploadedFile::class, [
			'getClientOriginalName' => 'foo.jpg',
			'getClientOriginalExtension' => 'jpg',
			'getPath' => 'path',
			'getClientMimeType' => 'image/jpg',
			'guessClientExtension' => 'jpg',
			'getClientSize' => 100,
			'isValid' => true,
			'guessExtension' => 'jpg',
		]);
	}

	/**
	 * @return Mock
	 */
	protected function generateInvalidStubUploadedFile()
	{
		return $this->mock(UploadedFile::class, [
			'getClientOriginalName' => 'foo.xyz',
			'getClientOriginalExtension' => 'xyz',
			'getPath' => 'path',
			'getClientMimeType' => 'foo/xyz',
			'guessClientExtension' => 'xyz',
			'getClientSize' => 100,
			'isValid' => true,
			'guessExtension' => 'xyz',
		]);
	}
}