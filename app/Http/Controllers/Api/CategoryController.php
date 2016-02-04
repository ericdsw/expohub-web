<?php

namespace ExpoHub\Http\Controllers\Api;

use Illuminate\Http\Request;
use ExpoHub\Repositories\Contracts\CategoryRepository;
use ExpoHub\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class CategoryController extends ApiController
{
	/** @var CategoryRepository */
	private $categoryRepository;

	/**
	 * CategoryController constructor.
	 *
	 * @param CategoryRepository $categoryRepository
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param CategoryTransformer $categoryTransformer
	 */
	public function __construct(CategoryRepository $categoryRepository,
								Manager $fractal, JsonApiSerializer $serializer,
								CategoryTransformer $categoryTransformer)
	{
		parent::__construct($fractal, $serializer, $categoryTransformer);
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * Returns a list of categories
	 *
	 * @return JsonResponse
	 */
	public function index()
	{
		return $this->respondJson($this->categoryRepository->all());
	}

	/**
	 * Returns specified category
	 *
	 * @param $id
	 * @return JsonResponse
	 */
	public function show($id)
	{
		return $this->respondJson($this->categoryRepository->find($id));
	}

	/**
	 * Creates category in the database
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function store(Request $request)
	{
		return $this->respondJson(
			$this->categoryRepository->create($request->only('name', 'fair_id'))
		);
	}

	/**
	 * Updates category
	 *
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(Request $request, $id)
	{
		return $this->respondJson(
			$this->categoryRepository->update($id, $request->only('name', 'fair_id'))
		);
	}

	/**
	 * Deletes category
	 *
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy($id)
	{
		$this->categoryRepository->delete($id);
		return $this->respondNoContent();
	}
}