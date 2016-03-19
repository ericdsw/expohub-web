<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Http\Controllers\Controller;
use ExpoHub\Repositories\Contracts\Repository;
use ExpoHub\Transformers\BaseTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;

abstract class ApiController extends Controller
{
	/** @var BaseTransformer */
	protected $transformer;

	/** @var Manager */
	protected $fractal;

	/** @var int */
	private $statusCode = 200;

	/** @var array */
	private $headers = [];

	/** @var array  */
	private $meta = [];

	/**
	 * ApiController constructor.
	 *
	 * @param Manager $fractal
	 * @param SerializerAbstract $serializer
	 * @param BaseTransformer $transformer
	 */
	public function __construct(Manager $fractal, SerializerAbstract $serializer, BaseTransformer $transformer)
	{
		$this->fractal = $fractal;
		$this->fractal->setSerializer($serializer);
		$this->transformer = $transformer;
	}

	/**
	 * Returns json formatted response
	 *
	 * @param $data
	 * @return JsonResponse
	 */
	protected function respondJson($data)
	{
		if(request()->has('include')) {
			$this->fractal->parseIncludes(request()->get('include'));
		}

		if($data instanceof Collection) {
			return $this->respondWithCollection($data);
		}
		else if($data instanceof Model) {
			return $this->respondWithModel($data);
		}
		else {
			return response()->json($data, $this->statusCode, $this->headers);
		}
	}

	/**
	 * Returns status code when providing no content
	 *
	 * @return JsonResponse
	 */
	protected function respondNoContent()
	{
		$this->setStatus(204);
		return $this->respondJson('');
	}

	/**
	 * Returns formatted json error with appropriated status code
	 *
	 * @param array $errors
	 * @param int $statusCode
	 * @return JsonResponse
	 */
	protected function respondError($errors, $statusCode = 400)
	{
		$this->setStatus($statusCode);
		return $this->respondJson(['errors' => $errors]);
	}

	/**
	 * Returns formatted error response when user is not authorized to view the resource
	 *
	 * @return JsonResponse
	 */
	protected function respondUnauthorized()
	{
		$this->setStatus(403);
		return $this->respondJson([
			'errors' => [
				'title' 		=> 'unauthorized',
				'description' 	=> 'not authorized to perform this request',
				'status' 		=> '403'
			]
		]);
	}

	/**
	 * Converts include parameter to eager loading array to optimize model dependency loading
	 * Will reduce subsequent calls to the database generated by the request
	 *
	 * @param Request $request
	 * @return array
	 */
	protected function parseEagerLoading(Request $request)
	{
		return $request->has('include') ? explode(',', $request->get('include')) : [];
	}

	/**
	 * Sets status for next response
	 *
	 * @param int $status
	 */
	public function setStatus($status)
	{
		$this->statusCode = $status;
	}

	/**
	 * Appends entry to header array
	 *
	 * @param array $data
	 */
	public function appendHeader(array $data)
	{
		array_push($this->headers, $data);
	}

	/**
	 * Empties the header array
	 */
	public function clearHeaders()
	{
		$this->headers = [];
	}

	/**
	 * Appends entry to meta array
	 *
	 * @param array $data
	 */
	public function appendMeta(array $data)
	{
		array_push($this->meta, $data);
	}

	/**
	 * Empties the meta array
	 */
	public function clearMeta()
	{
		$this->meta = [];
	}

	/**
	 * Returns formatted response for given model
	 * Utilizes JsonAPI Standard
	 *
	 * @param $model
	 * @return JsonResponse
	 */
	private function respondWithModel($model)
	{
		$resource = new Item($model, $this->transformer, $this->transformer->getType());

		if(! empty($this->meta)) {
			$resource->setMeta($this->meta);
		}

		$responseData = $this->fractal->createData($resource)->toArray();
		return response()->json($responseData, $this->statusCode, $this->headers);
	}

	/**
	 * Returns formatted response for given collection
	 * Utilizes JsonAPI Standard
	 *
	 * @param $collection
	 * @return JsonResponse
	 */
	private function respondWithCollection($collection)
	{
		$resource = new FractalCollection($collection, $this->transformer, $this->transformer->getType());

		if(! empty($this->meta)) {
			$resource->setMeta($this->meta);
		}

		$responseData = $this->fractal->createData($resource)->toArray();
		return response()->json($responseData, $this->statusCode, $this->headers);
	}

	/**
	 * @param Repository $repository
	 * @param Request $request
	 */
	protected function prepareRepo(Repository $repository, Request $request)
	{
		if($request->has('include')) {
			$repository->prepareEagerLoading(
				explode(',', $request->get('include'))
			);
		}

		if($request->has('sort')) {
			$sortParameter = $request->get('sort');
			if(preg_match('#^-#', $sortParameter)) {
				$repository->prepareOrderBy(substr($sortParameter, 1, strlen($sortParameter)), 'DESC');
			}
			else {
				$repository->prepareOrderBy($sortParameter, 'ASC');
			}
		}
	}
}