<?php


use ExpoHub\User;
use Mockery\Mock;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tymon\JWTAuth\JWTAuth;

abstract class BaseControllerTestCase extends TestCase
{
	/** @var JWTAuth|Mockery\Mock */
	protected $jwtAuth;

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

	/**
	 * Registers logged in user for Api transactions
	 *
	 * @param int $id
	 * @return array
	 */
	public function loginForApi($id = 1)
	{
		$this->jwtAuth = $this->mock(JWTAuth::class);

		$user = new User;
		$user->id = $id;
		$user->name = "name";
		$user->setRelation('roles', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')->andReturn($this->jwtAuth);
		$this->jwtAuth->shouldReceive('toUser')->andReturn($user);
}