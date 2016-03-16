<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateSponsorRequest;
use ExpoHub\Http\Requests\DeleteSponsorRequest;
use ExpoHub\Http\Requests\UpdateSponsorRequest;
use ExpoHub\Repositories\Contracts\SponsorRepository;
use ExpoHub\Transformers\SponsorTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class SponsorController extends ApiController
{
	/** @var SponsorRepository */
	private $sponsorRepository;

	/**
	 * SponsorController constructor.
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param SponsorTransformer $transformer
	 * @param SponsorRepository $repository
	 */
	public function __construct(Manager $fractal, JsonApiSerializer $serializer,
								SponsorTransformer $transformer, SponsorRepository $repository)
	{
		parent::__construct($fractal, $serializer, $transformer);
		$this->sponsorRepository = $repository;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->sponsorRepository, $request);
		return $this->respondJson($this->sponsorRepository->all());
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->sponsorRepository, $request);
		return $this->respondJson($this->sponsorRepository->find($id));
	}

	/**
	 * @param CreateSponsorRequest $request
	 * @param FileManager $fileManager
	 * @return JsonResponse
	 */
	public function store(CreateSponsorRequest $request, FileManager $fileManager)
	{
		$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));
		return $this->respondJson(
			$this->sponsorRepository->create(array_merge($request->all(), [
				'logo' => $imageUrl
			]))
		);
	}

	/**
	 * @param UpdateSponsorRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateSponsorRequest $request, FileManager $fileManager, $id)
	{
		$imageUrl = $this->sponsorRepository->find($id)->logo;
		if($request->hasFile('image')) {
			$fileManager->deleteFile($imageUrl);
			$imageUrl = $fileManager->uploadFile('/uploads', $request->file('image'));
		}
		return $this->respondJson(
			$this->sponsorRepository->update($id, array_merge($request->all(), [
				'logo' => $imageUrl
			]))
		);
	}

	/**
	 * @param DeleteSponsorRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteSponsorRequest $request, FileManager $fileManager, $id)
	{
		$fileManager->deleteFile(
			$this->sponsorRepository->find($id)->logo
		);
		$this->sponsorRepository->delete($id);

		return $this->respondNoContent();
	}

	/**
	 * @param Request $request
	 * @param $fairId
	 * @return JsonResponse
	 */
	public function getByFair(Request $request, $fairId)
	{
		$this->prepareRepo($this->sponsorRepository, $request);
		return $this->respondJson($this->sponsorRepository->getByFair($fairId));
	}

	/**
	 * @param Request $request
	 * @param $sponsorRankId
	 * @return JsonResponse
	 */
	public function getBySponsorRank(Request $request, $sponsorRankId)
	{
		$this->prepareRepo($this->sponsorRepository, $request);
		return $this->respondJson($this->sponsorRepository->getBySponsorRank($sponsorRankId));
	}
}