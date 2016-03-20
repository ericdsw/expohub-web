<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateFairEventRequest;
use ExpoHub\Http\Requests\DeleteFairEventRequest;
use ExpoHub\Http\Requests\UpdateFairEventRequest;
use ExpoHub\Repositories\Contracts\FairEventRepository;
use ExpoHub\Transformers\FairEventTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class FairEventController extends ApiController
{
	/** @var FairEventRepository */
	private $repository;

	/**
	 * FairEventController constructor.
	 *
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param FairEventTransformer $transformer
	 * @param FairEventRepository $repository
	 */
	public function __construct(Manager $fractal, JsonApiSerializer $serializer,
								FairEventTransformer $transformer, FairEventRepository $repository)
	{
		parent::__construct($fractal, $serializer, $transformer);
		$this->repository = $repository;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->repository, $request);
		return $this->respondJson($this->repository->all());
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->repository, $request);
		return $this->respondJson($this->repository->find($id));
	}

	/**
	 * @param CreateFairEventRequest $request
	 * @param FileManager $fileManager
	 * @return JsonResponse
	 */
	public function store(CreateFairEventRequest $request, FileManager $fileManager)
	{
		$parameters = $request->only('title', 'description', 'date', 'location', 'fair_id', 'event_type_id');
		$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));

		$this->setStatus(Response::HTTP_CREATED);

		$fairEvent = $this->repository->create(array_merge($parameters, [
			'image' => $imageUrl
		]));
		return $this->respondJson($fairEvent);
	}

	/**
	 * @param UpdateFairEventRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateFairEventRequest $request, FileManager $fileManager, $id)
	{
		$parameters 	= $request->only('title', 'description', 'date', 'location');
		$currentImage 	= $this->repository->find($id)->image;

		if($request->hasFile('image')) {
			$currentImage = $fileManager->uploadFile('/uploads', $request->file('image'));
		}
		$fairEvent = $this->repository->update($id, array_merge($parameters, [
			'image' => $currentImage
		]));
		return $this->respondJson($fairEvent);
	}

	/**
	 * @param $id
	 * @param FileManager $fileManager
	 * @param DeleteFairEventRequest $request
	 * @return JsonResponse
	 */
	public function destroy($id, FileManager $fileManager, DeleteFairEventRequest $request)
	{
		$currentImage = $this->repository->find($id)->image;
		$fileManager->deleteFile($currentImage);
		$this->repository->delete($id);
		return $this->respondNoContent();
	}

	/**
	 * @param Request $request
	 * @param $fairId
	 * @return JsonResponse
	 */
	public function getByFair(Request $request, $fairId)
	{
		$this->prepareRepo($this->repository, $request);
		return $this->respondJson($this->repository->getByFair($fairId));
	}

	/**
	 * @param Request $request
	 * @param $eventTypeId
	 * @return JsonResponse
	 */
	public function getByEventType(Request $request, $eventTypeId)
	{
		$this->prepareRepo($this->repository, $request);
		return $this->respondJson($this->repository->getByEventType($eventTypeId));
	}

	/**
	 * @param Request $request
	 * @param $userId
	 * @return JsonResponse
	 */
	public function getByAttendingUser(Request $request, $userId)
	{
		$this->prepareRepo($this->repository, $request);
		return $this->respondJson($this->repository->getByAttendingUser($userId));
	}
}