<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateStandRequest;
use ExpoHub\Http\Requests\DeleteStandRequest;
use ExpoHub\Http\Requests\UpdateStandRequest;
use ExpoHub\Repositories\Contracts\StandRepository;
use ExpoHub\Transformers\StandTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class StandController extends ApiController
{
	/** @var StandRepository */
	private $standRepository;

	public function __construct(Manager $fractal, JsonApiSerializer $serializer,
								StandTransformer $transformer, StandRepository $standRepository)
	{
		parent::__construct($fractal, $serializer, $transformer);
		$this->standRepository = $standRepository;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->standRepository, $request);
		return $this->respondJson($this->standRepository->all());
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->standRepository, $request);
		return $this->respondJson($this->standRepository->find($id));
	}

	/**
	 * @param CreateStandRequest $request
	 * @param FileManager $fileManager
	 * @return JsonResponse
	 */
	public function store(CreateStandRequest $request, FileManager $fileManager)
	{
		$imageUrl 	= $fileManager->uploadFile('/uploads', $request->file('image'));
		$parameters = $request->only('name', 'image', 'fair_id');

		$this->setStatus(Response::HTTP_CREATED);

		return $this->respondJson(
			$this->standRepository->create(array_merge($parameters, [
				'image' => $imageUrl
			]))
		);
	}

	/**
	 * @param UpdateStandRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateStandRequest $request, FileManager $fileManager, $id)
	{
		$stand 		= $this->standRepository->find($id);
		$imageUrl 	= $stand->image;

		if($request->hasFile('image')) {
			$fileManager->deleteFile($imageUrl);
			$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));
		}

		return $this->respondJson(
			$this->standRepository->update($id, [
				'name' 			=> $request->has('name') ? $request->get('name') : $stand->name,
				'description' 	=> $request->has('description') ? $request->get('description') : $stand->description,
				'image' 		=> $imageUrl
			])
		);
	}

	/**
	 * @param DeleteStandRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteStandRequest $request, FileManager $fileManager, $id)
	{
		$fileManager->deleteFile(
			$this->standRepository->find($id)->image
		);
		$this->standRepository->delete($id);

		return $this->respondNoContent();
	}

	/**
	 * @param Request $request
	 * @param $fairId
	 * @return JsonResponse
	 */
	public function getByFair(Request $request, $fairId)
	{
		$this->prepareRepo($this->standRepository, $request);
		return $this->respondJson(
			$this->standRepository->getByFair($fairId)
		);
	}
}