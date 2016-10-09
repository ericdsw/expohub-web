<?php
namespace ExpoHub\Http\Controllers\Api;

use ExpoHub\Constants\UserType;
use ExpoHub\Helpers\Credentials\Contracts\CredentialsHelper;
use ExpoHub\Http\Requests\LoginRequest;
use ExpoHub\Http\Requests\RegisterRequest;
use ExpoHub\Repositories\Contracts\UserRepository;
use ExpoHub\Specifications\UserSpecification;
use ExpoHub\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends ApiController
{
	/** @var UserRepository */
	private $userRepository;

	/**
	 * AuthController constructor
	 *
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param UserTransformer $transformer
	 * @param UserRepository $userRepository
	 */
	public function __construct(
		Manager $fractal, JsonApiSerializer $serializer,
		UserTransformer $transformer, UserRepository $userRepository
	) {
		parent::__construct($fractal, $serializer, $transformer);
		$this->userRepository = $userRepository;
	}

	/**
	 * Logins the user
	 *
	 * @param CredentialsHelper $helper
	 * @param LoginRequest $request
	 * @param JWTAuth $jwtAuth
	 * @return JsonResponse
	 */
	public function login(CredentialsHelper $helper, LoginRequest $request, JWTAuth $jwtAuth)
	{
		$authField = $helper->getLoginField($request->get('login_param'));

		$loginParameters = array_merge($request->only('password'), [
			$authField => $request->get('login_param')
		]);

		try {
			if (! $token = $jwtAuth->attempt($loginParameters)) {
				return $this->respondError([
					'title' 		=> 'invalid-credentials',
					'description' 	=> 'Invalid login credentials',
					'status' 		=> '400'
				]);
			}
		} catch (JWTException $e) {
			return $this->respondError([
				'title' 		=> 'jwt-exception',
				'description' 	=> 'Internal error occurred, please try again later',
				'status' 		=> '400'
			]);
		}

		$user = $jwtAuth->toUser($token);

		$this->appendMeta(['token' => $token]);

		return $this->respondJson($user);
	}

	/**
	 * Registers the user
	 *
	 * @param UserSpecification $specification
	 * @param RegisterRequest $request
	 * @param JWTAuth $jwtAuth
	 * @return JsonResponse
	 */
	public function register(UserSpecification $specification, RegisterRequest $request, JWTAuth $jwtAuth)
	{
		if (! $specification->isEmailAvailable($request->get('email'))) {
			return $this->respondError([
				'title' 		=> 'email-taken',
				'description' 	=> 'Email is already taken',
				'status' 		=> '409'
			], 409);
		}
		if (! $specification->isUsernameAvailable($request->get('username'))) {
			return $this->respondError([
				'title' 		=> 'username-taken',
				'description' 	=> 'Username is already taken',
				'status' 		=> '409'
			], 409);
		}

		$parameters = $request->only('name', 'username', 'email');

		$user = $this->userRepository->create(array_merge($parameters, [
			'password' => bcrypt($request->get('password')),
			'user_type' => UserType::TYPE_USER
		]));

		$token = $jwtAuth->fromUser($user);

		$this->appendMeta(['token' => $token]);

		$this->setStatus(Response::HTTP_CREATED);

		return $this->respondJson($user);
	}

	/**
	 * Logout the user from the application
	 *
	 * @param JWTAuth $jwtAuth
	 * @return JsonResponse
	 */
	public function logout(JWTAuth $jwtAuth)
	{
		$token = $jwtAuth->getToken();
		$jwtAuth->invalidate($token);

		return $this->respondNoContent();
	}
}
