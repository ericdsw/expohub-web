<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateSpeakerRequest;
use ExpoHub\Http\Requests\DeleteSpeakerRequest;
use ExpoHub\Http\Requests\UpdateSpeakerRequest;
use ExpoHub\Repositories\Contracts\SpeakerRepository;
use ExpoHub\Transformers\SpeakerTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class SpeakerController extends ApiController
{
	private $speakerRepository;

	/**
	 * SpeakerController constructor.
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param SpeakerTransformer $transformer
	 * @param SpeakerRepository $repository
	 */
	public function __construct(Manager $fractal, JsonApiSerializer $serializer,
								SpeakerTransformer $transformer, SpeakerRepository $repository)
	{
		parent::__construct($fractal, $serializer, $transformer);
		$this->speakerRepository = $repository;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->speakerRepository, $request);
		return $this->respondJson($this->speakerRepository->all());
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->speakerRepository, $request);
		return $this->respondJson($this->speakerRepository->find($id));
	}

	/**
	 * @param CreateSpeakerRequest $request
	 * @param FileManager $fileManager
	 * @return JsonResponse
	 */
	public function store(CreateSpeakerRequest $request, FileManager $fileManager)
	{
		$imageUrl 	= $fileManager->uploadFile('uploads/', $request->file('image'));
		$parameters = $request->only('name', 'image', 'description', 'fair_event_id');

		$this->setStatus(Response::HTTP_CREATED);

		return $this->respondJson(
			$this->speakerRepository->create(array_merge($parameters, [
				'picture' => $imageUrl
			]))
		);
	}

	/**
	 * @param UpdateSpeakerRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateSpeakerRequest $request, FileManager $fileManager, $id)
	{
		$speaker 	= $this->speakerRepository->find($id);
		$imageUrl 	= $speaker->picture;

		if($request->hasFile('image')) {
			$fileManager->deleteFile($imageUrl);
			$imageUrl = $fileManager->uploadFile('uploads/', $request->file('image'));
		}

		return $this->respondJson(
			$this->speakerRepository->update($id, [
				'name' 			=> $request->has('name') ? $request->get('name') : $speaker->name,
				'image' 		=> $imageUrl,
				'description' 	=> $request->has('description') ? $request->get('description') : $speaker->description
			])
		);
	}

	/**
	 * @param DeleteSpeakerRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteSpeakerRequest $request, FileManager $fileManager, $id)
	{
		$fileManager->deleteFile(
			$this->speakerRepository->find($id)->picture
		);
		$this->speakerRepository->delete($id);

		return $this->respondNoContent();
	}

	/**
	 * @param Request $request
	 * @param $fairEventId
	 * @return JsonResponse
	 */
	public function getByFairEvent(Request $request, $fairEventId)
	{
		$this->prepareRepo($this->speakerRepository, $request);
		return $this->respondJson(
			$this->speakerRepository->getByFairEvents($fairEventId)
		);
	}
}