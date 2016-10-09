<?php
namespace ExpoHub\Http\Controllers\Api;

use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Http\Requests\CreateFairRequest;
use ExpoHub\Http\Requests\DeleteFairRequest;
use ExpoHub\Http\Requests\UpdateFairRequest;
use ExpoHub\Repositories\Contracts\FairRepository;
use ExpoHub\Transformers\FairTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use Tymon\JWTAuth\JWTAuth;

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
	public function __construct(
		FairRepository $fairRepository, Manager $fractal,
		JsonApiSerializer $serializer, FairTransformer $transformer
	) {
		parent::__construct($fractal, $serializer, $transformer);
		$this->fairRepository = $fairRepository;
	}

	/**
	 * Shows a list of fairs
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->fairRepository, $request);
		return $this->respondJson($this->fairRepository->all());
	}

	/**
	 * Shows specified fair
	 *
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->fairRepository, $request);
		return $this->respondJson($this->fairRepository->find($id));
	}

	/**
	 * Creates a new fair
	 *
	 * @param CreateFairRequest $request
	 * @param FileManager $manager
	 * @param JWTAuth $jwtAuth
	 * @return JsonResponse
	 */
	public function store(CreateFairRequest $request, FileManager $manager, JWTAuth $jwtAuth)
	{
		$parameters = $request->only('name', 'description', 'website', 'starting_date',
			'ending_date', 'address', 'latitude', 'longitude');

		$this->setStatus(Response::HTTP_CREATED);

		return $this->respondJson(
			$this->fairRepository->create(array_merge($parameters, [
				'image' 	=> $manager->uploadFile('uploads/', $request->file('image')),
				'user_id' 	=> $jwtAuth->parseToken()->toUser()->id
			]))
		);
	}

	/**
	 * Updates specified fair
	 *
	 * @param UpdateFairRequest $request
	 * @param FileManager $manager
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateFairRequest $request, FileManager $manager, $id)
	{
		$currentFair 	= $this->fairRepository->find($id);
		$imagePath 		= $currentFair->image;

		if ($request->hasFile('image')) {
			$manager->deleteFile($imagePath);
			$imagePath = $manager->uploadFile('uploads/', $request->file('image'));
		}

		return $this->respondJson(
			$this->fairRepository->create([
				'name' 			=> $request->has('name') ? $request->get('name') : $currentFair->name,
				'image' 		=> $imagePath,
				'description' 	=> $request->has('description') ? $request->get('description') : $currentFair->description,
				'website' 		=> $request->has('website') ? $request->get('website') : $currentFair->website,
				'starting_date' => $request->has('starting_date') ? $request->get('starting_date') : $currentFair->starting_date,
				'ending_date' 	=> $request->has('ending_date') ? $request->get('ending_date') : $currentFair->ending_date,
				'address' 		=> $request->has('address') ? $request->get('address') : $currentFair->address,
				'latitude' 		=> $request->has('latitude') ? $request->get('latitude') : $currentFair->latitude,
				'longitude' 	=> $request->has('longitude') ? $request->get('longitude') : $currentFair->longitude
			])
		);
	}

	/**
	 * Deletes specified fair
	 *
	 * @param DeleteFairRequest $request
	 * @param FileManager $fileManager
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteFairRequest $request, FileManager $fileManager, $id)
	{
		$imagePath = $this->fairRepository->find($id);
		$fileManager->deleteFile($imagePath);
		$this->fairRepository->delete($id);

		return $this->respondNoContent();
	}

	/**
	 * Gets fairs created by the specified user
	 *
	 * @param Request $request
	 * @param $userId
	 * @return JsonResponse
	 */
	public function getByUser(Request $request, $userId)
	{
		$this->prepareRepo($this->fairRepository, $request);
		return $this->respondJson(
			$this->fairRepository->getByUser($userId)
		);
	}

	/**
	 * Gets all active fairs
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function getActiveFairs(Request $request)
	{
		$this->prepareRepo($this->fairRepository, $request);
		return $this->respondJson($this->fairRepository->getActiveFairs());
	}
}
