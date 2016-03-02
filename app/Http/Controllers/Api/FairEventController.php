<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateFairEventRequest;
use ExpoHub\Http\Requests\UpdateFairEventRequest;
use ExpoHub\Repositories\Contracts\FairEventRepository;
use ExpoHub\Transformers\FairEventTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
		return $this->respondJson($this->repository->all(
			$this->parseEagerLoading($request)
		));
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		return $this->respondJson($this->repository->find(
			$id, $this->parseEagerLoading($request)
		));
	}

	/**
	 * @param CreateFairEventRequest $request
	 * @param FileManager $fileManager
	 * @return JsonResponse
	 */
	public function store(CreateFairEventRequest $request, FileManager $fileManager)
	{
		$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));
		$fairEvent = $this->repository->create(array_merge($request->all(), [
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
		$currentImage = $this->repository->find($id)->image;
		if($request->hasFile('image')) {
			$currentImage = $fileManager->uploadFile('/uploads', $request->file('image'));
		}
		$fairEvent = $this->repository->update($id, array_merge($request->all(), [
			'image' => $currentImage
		]));
		return $this->respondJson($fairEvent);
	}

	/**
	 * @param $id
	 * @param FileManager $fileManager
	 * @return JsonResponse
	 */
	public function destroy($id, FileManager $fileManager)
	{
		$currentImage = $this->repository->find($id)->image;
		$fileManager->deleteFile($currentImage);
		$this->repository->delete($id);
		return $this->respondNoContent();
	}

	/**
	 * @param $fairId
	 * @return JsonResponse
	 */
	public function getByFair($fairId)
	{
		return $this->respondJson($this->repository->getByFair($fairId));
	}

	/**
	 * @param $eventTypeId
	 * @return JsonResponse
	 */
	public function getByEventType($eventTypeId)
	{
		return $this->respondJson($this->repository->getByEventType($eventTypeId));
	}

	/**
	 * @param $userId
	 * @return JsonResponse
	 */
	public function getByAttendingUser($userId)
	{
		return $this->respondJson($this->repository->getByAttendingUser($userId));
	}
}