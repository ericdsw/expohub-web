<?php

namespace ExpoHub\Http\Controllers\Api;

use ExpoHub\Http\Requests\ListApiTokensRequest;
use ExpoHub\Http\Requests\ShowApiTokenRequest;
use ExpoHub\Repositories\Contracts\ApiTokenRepository;
use ExpoHub\Transformers\ApiTokenTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use ExpoHub\Http\Requests;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class ApiTokenController extends ApiController
{
	/** @var ApiTokenRepository */
	private $apiTokenRepository;

	public function __construct(Manager $fractal, JsonApiSerializer $serializer,
								ApiTokenTransformer $transformer, ApiTokenRepository $apiTokenRepository)
	{
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
     * Store a newly created resource in storage.
     *
     * @param  Request $request
	 * @return JsonResponse
     */
    public function store(Request $request)
    {
		$appId 		= str_random(32);
		$appSecret 	= str_random(32);

		$apiToken = $this->apiTokenRepository->create([
			'name' => $request->get('name'),
			'app_id' => $appId,
			'app_secret' => $appSecret
		]);
		$this->setStatus(Response::HTTP_CREATED);

		return $this->respondJson($apiToken);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
	 * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        return $this->respondJson(
			$this->apiTokenRepository->update($id, $request->only('name'))
		);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
	 * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->apiTokenRepository->delete($id);

		return $this->respondNoContent();
    }
}
