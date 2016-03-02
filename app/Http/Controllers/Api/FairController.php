<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateFairRequest;
use ExpoHub\Http\Requests\UpdateFairRequest;
use ExpoHub\Repositories\Contracts\FairRepository;
use ExpoHub\Transformers\FairTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class FairController extends ApiController
{
	/** @var FairRepository */
	private $fairRepository;

	/**
	 * FairController constructor.
	 *
	 * @param FairRepository $fairRepository
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param FairTransformer $transformer
	 */
	public function __construct(FairRepository $fairRepository, Manager $fractal,
								JsonApiSerializer $serializer, FairTransformer $transformer)
	{
		parent::__construct($fractal, $serializer, $transformer);
		$this->fairRepository = $fairRepository;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		return $this->respondJson($this->fairRepository->all(
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
		return $this->respondJson($this->fairRepository->find(
			$id, $this->parseEagerLoading($request)
		));
	}

	/**
	 * @param CreateFairRequest $request
	 * @param FileManager $manager
	 * @return JsonResponse
	 */
	public function store(CreateFairRequest $request, FileManager $manager)
	{
		return $this->respondJson(
			$this->fairRepository->create(array_merge($request->all(), [
				'image' => $manager->uploadFile('uploads/', $request->file('image'))
			]))
		);
	}

	/**
	 * @param UpdateFairRequest $request
	 * @param FileManager $manager
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateFairRequest $request, FileManager $manager, $id)
	{
		$imagePath = $this->fairRepository->find($id)->image;
		if($request->hasFile('image')) {
			$manager->deleteFile($imagePath);
			$imagePath = $manager->uploadFile('uploads/', $request->file('image'));
		}
		return $this->respondJson(
			$this->fairRepository->create(array_merge($request->all(), [
				'image' => $imagePath
			]))
		);
	}

	/**
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(FileManager $fileManager, $id)
	{
		$imagePath = $this->fairRepository->find($id);
		$fileManager->deleteFile($imagePath);
		$this->fairRepository->delete($id);

		return $this->respondNoContent();
	}

	/**
	 * @param $userId
	 * @return JsonResponse
	 */
	public function getByUser($userId)
	{
		return $this->respondJson(
			$this->fairRepository->getByUser($userId)
		);
	}

	/**
	 * @return JsonResponse
	 */
	public function getActiveFairs()
	{
		return $this->respondJson($this->fairRepository->getActiveFairs());
	}
}