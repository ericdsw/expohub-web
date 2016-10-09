<?php
namespace ExpoHub\Http\Controllers\Api;

use ExpoHub\Http\Requests\CreateSponsorRankRequest;
use ExpoHub\Http\Requests\DeleteSponsorRankRequest;
use ExpoHub\Http\Requests\UpdateSponsorRankRequest;
use ExpoHub\Repositories\Contracts\SponsorRankRepository;
use ExpoHub\Transformers\SponsorRankTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class SponsorRankController extends ApiController
{
	/** @var SponsorRankRepository */
	private $sponsorRankRepository;

	/**
	 * SponsorRankController constructor
	 *
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param SponsorRankTransformer $transformer
	 * @param SponsorRankRepository $repository
	 */
	public function __construct(
		Manager $fractal, JsonApiSerializer $serializer,
 		SponsorRankTransformer $transformer, SponsorRankRepository $repository
 	) {
		parent::__construct($fractal, $serializer, $transformer);
		$this->sponsorRankRepository = $repository;
	}

	/**
	 * Shows list of sponsorRanks
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->sponsorRankRepository, $request);
		return $this->respondJson(
			$this->sponsorRankRepository->all()
		);
	}

	/**
	 * Shows specified sponsorRank
	 *
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->sponsorRankRepository, $request);
		return $this->respondJson(
			$this->sponsorRankRepository->find($id)
		);
	}

	/**
	 * Stores new sponsorRank
	 *
	 * @param CreateSponsorRankRequest $request
	 * @return JsonResponse
	 */
	public function store(CreateSponsorRankRequest $request)
	{
		$parameters = $request->only('name');

		$this->setStatus(Response::HTTP_CREATED);

		return $this->respondJson(
			$this->sponsorRankRepository->create($parameters)
		);
	}

	/**
	 * Updates specified sponsorRank
	 *
	 * @param UpdateSponsorRankRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateSponsorRankRequest $request, $id)
	{
		$sponsorRank = $this->sponsorRankRepository->find($id);

		return $this->respondJson(
			$this->sponsorRankRepository->update($id, [
				'name' => $request->has('name') ? $request->get('name') : $sponsorRank->name
			])
		);
	}

	/**
	 * Deletes specified sponsorRank
	 *
	 * @param DeleteSponsorRankRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteSponsorRankRequest $request, $id)
	{
		$this->respondJson($this->sponsorRankRepository->delete($id));
		return $this->respondNoContent();
	}
}
