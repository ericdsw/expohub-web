<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateMapRequest;
use ExpoHub\Http\Requests\UpdateMapRequest;
use ExpoHub\Repositories\Contracts\MapRepository;
use ExpoHub\Transformers\MapTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class MapController extends ApiController
{
	/** @var MapRepository */
	private $repository;

	/**
	 * MapController constructor.
	 *
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param MapTransformer $transformer
	 * @param MapRepository $repository
	 */
	public function __construct(Manager $fractal, JsonApiSerializer $serializer,
								MapTransformer $transformer, MapRepository $repository)
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
	 * @param CreateMapRequest $request
	 * @param FileManager $fileManager
	 * @return JsonResponse
	 */
	public function store(CreateMapRequest $request, FileManager $fileManager)
	{
		$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));
		$map = $this->repository->create(array_merge($request->all(), [
			'image' => $imageUrl
		]));
		return $this->respondJson($map);
	}

	/**
	 * @param UpdateMapRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateMapRequest $request, FileManager $fileManager, $id)
	{
		$map = $this->repository->find($id);
		$imageUrl = $map->image;
		if($request->hasFile('image')) {
			$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));
			$fileManager->deleteFile($map->image);
		}
		$map = $this->repository->update($id, array_merge($request->all(), [
			'image' => $imageUrl
		]));
		return $this->respondJson($map);
	}

	/**
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(FileManager $fileManager, $id)
	{
		$imageUrl = $this->repository->find($id)->image;
		$fileManager->deleteFile($imageUrl);
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
}