<?php
namespace ExpoHub\Http\Controllers\Api;

use ExpoHub\JsonError;
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
				return $this->jsonErrorGenerator->setStatus(400)
					->appendError(new JsonError("invalid-credentials", "Invalid login credentials", "400", ""))
					->generateErrorResponse();
			}
		} catch (JWTException $e) {
			return $this->jsonErrorGenerator->setStatus(400)
				->appendError(new JsonError("jwt-exception", "Internal error ocurred, please try again later", "400", ""))
				->generateErrorResponse();
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
			return $this->jsonErrorGenerator->setStatus(409)
					->appendError(new JsonError("email-taken", "Email is already taken", "409", ""))
					->generateErrorResponse();
		}
		if (! $specification->isUsernameAvailable($request->get('username'))) {
			return $this->jsonErrorGenerator->setStatus(409)
					->appendError(new JsonError("username-taken", "Username is alredy taken", "409", ""))
					->generateErrorResponse();
		}

		$parameters = $request->only('name', 'username', 'email');

		$user = $this->userRepository->create(array_merge($parameters, [
			'password' 	=> bcrypt($request->get('password')),
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
