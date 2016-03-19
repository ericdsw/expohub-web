<?php


use ExpoHub\User;
use Mockery\Mock;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;

abstract class BaseControllerTestCase extends TestCase
{
	/** @var JWTAuth|Mockery\Mock */
	protected $jwtAuth;

	public function setUp()
	{
		parent::setUp();

		// Default jwtAuth behaviour, no token sent
		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->jwtAuth->shouldReceive('setRequest')
			->withAnyArgs()
			->andReturn($this->jwtAuth);
		$this->jwtAuth->shouldReceive('getToken')->andReturn(false);
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

	/**
	 * Registers logged in user for Api transactions
	 *
	 * @param int $id
	 * @return array
	 */
	public function loginForApi($id = 1)
	{
		$token = "foo";
		$this->jwtAuth = $this->mock(JWTAuth::class);

		$user = new User;
		$user->id = $id;
		$user->name = "name";
		$user->setRelation('roles', collect([]));

		// To get user data
		$this->jwtAuth->shouldReceive('parseToken')->andReturn($this->jwtAuth);
		$this->jwtAuth->shouldReceive('toUser')->andReturn($user);

		// To pass middleware implementation
		$this->jwtAuth->shouldReceive('setRequest')
			->withAnyArgs()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('getToken')->andReturn($token);

		$this->jwtAuth->shouldReceive('authenticate')
			->with($token)
			->andReturn($user);
	}

	/**
	 * Registers logged in user with expired token
	 *
	 * @param int $id
	 * @return array
	 */
	public function loginForApiWithExpiredToken($id = 1)
	{
		$token = "foo";
		$this->jwtAuth = $this->mock(JWTAuth::class);

		$user = new User;
		$user->id = $id;
		$user->name = "name";
		$user->setRelation('roles', collect([]));

		// To get user data
		$this->jwtAuth->shouldReceive('parseToken')->andReturn($this->jwtAuth);
		$this->jwtAuth->shouldReceive('toUser')->andReturn($user);

		// To pass middleware implementation
		$this->jwtAuth->shouldReceive('setRequest')
			->withAnyArgs()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('getToken')->andReturn($token);

		$this->jwtAuth->shouldReceive('authenticate')
			->with($token)
			->andThrow(TokenExpiredException::class, "", 401);
	}
}