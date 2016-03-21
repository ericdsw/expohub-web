<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Constants\UserType;
use ExpoHub\Http\Requests\CreateUserRequest;
use ExpoHub\Http\Requests\DeleteUserRequest;
use ExpoHub\Http\Requests\UpdateUserRequest;
use ExpoHub\Repositories\Contracts\UserRepository;
use ExpoHub\Specifications\UserSpecification;
use ExpoHub\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class UserController extends ApiController
{
	/** @var UserRepository */
	private $userRepository;

	/**
	 * UserController constructor.
	 *
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param UserTransformer $transformer
	 * @param UserRepository $repository
	 */
	public function __construct(Manager $fractal, JsonApiSerializer $serializer,
								UserTransformer $transformer, UserRepository $repository)
	{
		parent::__construct($fractal, $serializer, $transformer);
		$this->userRepository = $repository;
	}

	/**
	 * Lists all the resources
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->userRepository, $request);
		return $this->respondJson(
			$this->userRepository->all()
		);
	}

	/**
	 * Shows specified resource
	 *
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->userRepository, $request);
		return $this->respondJson(
			$this->userRepository->find($id)
		);
	}

	/**
	 * Creates resource
	 *
	 * @param CreateUserRequest $request
	 * @param UserSpecification $specification
	 * @return JsonResponse
	 */
	public function store(CreateUserRequest $request, UserSpecification $specification)
	{
		if(! $specification->isEmailAvailable($request->get('email'))) {
			return $this->respondError([
				'title' 		=> 'email-taken',
				'description' 	=> 'Email is already taken',
				'status' 		=> '409'
			], 409);
		}

		if(! $specification->isUsernameAvailable($request->get('username'))) {
			return $this->respondError([
				'title' 		=> 'username-taken',
				'description' 	=> 'Username is already taken',
				'status' 		=> '409'
			], 409);
		}

		$parameters = $request->only('name', 'username', 'email');

		$this->setStatus(Response::HTTP_CREATED);

		return $this->respondJson(
			$this->userRepository->create(array_merge($parameters, [
				'password'  => bcrypt($request->get('password')),
				'user_type' => UserType::TYPE_USER
			]))
		);
	}

	/**
	 * Updates resource
	 *
	 * @param UpdateUserRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateUserRequest $request, $id)
	{
		$user = $this->userRepository->find($id);

		return $this->respondJson(
			$this->userRepository->update($id, [
				'name' => $request->has('name') ? $request->get('name') : $user->name
			])
		);
	}

	/**
	 * Destroys resource
	 *
	 * @param DeleteUserRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteUserRequest $request, $id)
	{
		$this->userRepository->delete($id);
		return $this->respondNoContent();
	}
}