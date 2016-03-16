<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Http\Requests\CreateUserRequest;
use ExpoHub\Http\Requests\DeleteUserRequest;
use ExpoHub\Http\Requests\UpdateUserRequest;
use ExpoHub\Repositories\Contracts\UserRepository;
use ExpoHub\Specifications\UserSpecification;
use ExpoHub\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
			abort(409);
		}
		if(! $specification->isUsernameAvailable($request->get('username'))) {
			abort(409);
		}
		return $this->respondJson(
			$this->userRepository->create($request->all())
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
		return $this->respondJson(
			$this->userRepository->update($id, $request->all())
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