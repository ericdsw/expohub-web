<?php
namespace ExpoHub\Http\Controllers\Api;

use ExpoHub\Http\Requests\ListApiTokensRequest;
use ExpoHub\Http\Requests\ShowApiTokenRequest;
use ExpoHub\Repositories\Contracts\ApiTokenRepository;
use ExpoHub\Transformers\ApiTokenTransformer;
use Illuminate\Http\JsonResponse;

use ExpoHub\Http\Requests;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class ApiTokenController extends ApiController
{
	/** @var ApiTokenRepository */
	private $apiTokenRepository;

	/**
	 * ApiTokenController Constructor
	 * @param Manager             $fractal
	 * @param JsonApiSerializer   $serializer
	 * @param ApiTokenTransformer $transformer
	 * @param ApiTokenRepository  $apiTokenRepository
	 */
	public function __construct(
		Manager $fractal, 
		JsonApiSerializer $serializer,
		ApiTokenTransformer $transformer,
		ApiTokenRepository $apiTokenRepository
	) {
		parent::__construct($fractal, $serializer, $transformer);
		$this->apiTokenRepository = $apiTokenRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param ListApiTokensRequest $request
	 * @return JsonResponse
	 */
    public function index(ListApiTokensRequest $request)
    {
        $this->prepareRepo($this->apiTokenRepository, $request);
		return $this->respondJson($this->apiTokenRepository->all());
    }

	/**
	 * Display the specified resource.
	 *
	 * @param ShowApiTokenRequest $request
	 * @param  int $id
	 * @return JsonResponse
	 */
    public function show(ShowApiTokenRequest $request, $id)
    {
		$this->prepareRepo($this->apiTokenRepository, $request);
		return $this->respondJson($this->apiTokenRepository->find($id));
    }
}
