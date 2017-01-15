<?php
namespace ExpoHub\Http\Controllers\Api;

use ExpoHub\Http\Controllers\Controller;
use ExpoHub\Repositories\Contracts\Repository;
use ExpoHub\Transformers\BaseTransformer;
use ExpoHub\Helpers\Generators\Contracts\JsonErrorGenerator;
use ExpoHub\JsonError;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;

abstract class ApiController extends Controller
{
	/** @var BaseTransformer */
	protected $transformer;

	/** @var Manager */
	protected $fractal;

	/** @var JsonErrorGenerator */
	protected $jsonErrorGenerator;

	/** @var int */
	private $statusCode = Response::HTTP_OK;

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
		$this->fractal 				= $fractal;
		$this->transformer 			= $transformer;
		$this->jsonErrorGenerator 	= app()->make(JsonErrorGenerator::class);
		$this->fractal->setSerializer($serializer);
	}

	/**
	 * Returns json formatted response
	 *
	 * @param $data
	 * @return JsonResponse
	 */
	protected function respondJson($data)
	{
		if (request()->has('include')) {
			$this->fractal->parseIncludes(request()->get('include'));
		}

		if ($data instanceof Collection) {
			return $this->respondWithCollection($data);
		} elseif ($data instanceof Model) {
			return $this->respondWithModel($data);
		} else {
			return response()->json($data, $this->statusCode, $this->getHeaders());
		}
	}

	/**
	 * Returns status code when providing no content
	 *
	 * @return JsonResponse
	 */
	protected function respondNoContent()
	{
		$this->setStatus(Response::HTTP_NO_CONTENT);
		return $this->respondJson('');
	}
	
	/**
	 * Returns formatted error response when user is not authorized to view the resource
	 *
	 * @return JsonResponse
	 */
	protected function respondUnauthorized()
	{
		$this->setStatus(Response::HTTP_FORBIDDEN);
		$responseBody = $this->jsonErrorGenerator->setStatus($this->status)
			->appendError(new JsonError("unauthorized", "not authorized to perform this request", (string) $this->status, ""))
			->generateErrorJson();

		return $this->respondJson($responseBody);
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

		if (! empty($this->meta)) {
			$resource->setMeta($this->meta);
		}

		$responseData = $this->fractal->createData($resource)->toArray();
		return response()->json($responseData, $this->statusCode, $this->getHeaders());
	}

	/**
	 * Returns formatted response for given collection
	 * Utilizes JsonAPI Standard
	 *
	 * @param $collection
	 * @return JsonResponse
	 */
	private function respondWithCollection(Collection $collection)
	{
		$resource = new FractalCollection($collection, $this->transformer, $this->transformer->getType());

		if (request()->has('page')) {

			$pageArray  = request()->get('page');

			if (array_key_exists('limit', $pageArray) && array_key_exists('cursor', $pageArray)) {
				
				$limit 		= $pageArray['limit'];
				$cursor 	= (int) $pageArray['cursor'];
				$previous 	= null;
				$next		= (count($collection) <= $limit) ? null : $limit + $cursor;

				if (array_key_exists('previous', $pageArray)) {
					$previous = $pageArray['previous'];
				}

				$resource->setCursor(new Cursor($cursor, $previous, $next, count($collection)));
			}
		}

		if (! empty($this->meta)) {
			$resource->setMeta($this->meta);
		}

		$responseData = $this->fractal->createData($resource)->toArray();
		return response()->json($responseData, $this->statusCode, $this->getHeaders());
	}

	/**
	 * @param Repository $repository
	 * @param Request $request
	 */
	protected function prepareRepo(Repository $repository, Request $request)
	{
		if ($request->has('include')) {
			$repository->prepareEagerLoading(
				explode(',', $request->get('include'))
			);
		}

		if ($request->has('page')) {
			$repository->prepareLimit($request->get('page')['limit'], $request->get('page')['cursor']);
		}

		if ($request->has('sort')) {
			$sortParameterArray = explode(',', $request->get('sort'));
			foreach($sortParameterArray as $sortParameter) {
				if(preg_match('#^-#', $sortParameter)) {
					$repository->prepareOrderBy(substr($sortParameter, 1, strlen($sortParameter)), 'DESC');
				}
				else {
					$repository->prepareOrderBy($sortParameter, 'ASC');
				}
			}
		}
	}

	/**
	 * Parses the headers array, including default values
	 *
	 * @return array
	 */
	private function getHeaders()
	{
		return array_merge($this->headers, [
			'Content-Type' => 'application/vnd.api+json'
		]);
	}
}
