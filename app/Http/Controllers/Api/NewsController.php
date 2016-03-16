<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateNewsRequest;
use ExpoHub\Http\Requests\UpdateNewsRequest;
use ExpoHub\Repositories\Contracts\NewsRepository;
use ExpoHub\Transformers\NewsTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class NewsController extends ApiController
{
	private $newsRepository;

	/**
	 * NewsController constructor.
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param NewsTransformer $transformer
	 * @param NewsRepository $newsRepository
	 */
	public function __construct(Manager $fractal, JsonApiSerializer $serializer,
								NewsTransformer $transformer, NewsRepository $newsRepository)
	{
		parent::__construct($fractal, $serializer, $transformer);
		$this->newsRepository = $newsRepository;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->newsRepository, $request);
		return $this->respondJson($this->newsRepository->all());
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->newsRepository, $request);
		return $this->respondJson($this->newsRepository->find($id));
	}

	/**
	 * @param CreateNewsRequest $request
	 * @param FileManager $fileManager
	 * @return JsonResponse
	 */
	public function store(CreateNewsRequest $request, FileManager $fileManager)
	{
		$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));
		return $this->respondJson(
			$this->newsRepository->create(array_merge($request->all(), [
				'image' => $imageUrl
			]))
		);
	}

	/**
	 * @param UpdateNewsRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateNewsRequest $request, FileManager $fileManager, $id)
	{
		$imageUrl = $this->newsRepository->find($id);
		if($request->hasFile('image')) {
			$fileManager->deleteFile($imageUrl);
			$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));
		}
		return $this->respondJson(
			$this->newsRepository->update($id, array_merge($request->all(), [
				'image' => $imageUrl
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
		$imageUrl = $this->newsRepository->find($id);
		$fileManager->deleteFile($imageUrl);
		$this->newsRepository->delete($id);

		return $this->respondNoContent();
	}

	/**
	 * @param Request $request
	 * @param $fairId
	 * @return JsonResponse
	 */
	public function getByFair(Request $request, $fairId)
	{
		$this->prepareRepo($this->newsRepository, $request);
		return $this->respondJson(
			$this->newsRepository->getByFair($fairId)
		);
	}
}