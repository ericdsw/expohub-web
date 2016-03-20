<?php

namespace ExpoHub\Http\Controllers\Api;

use ExpoHub\Http\Requests\CreateCategoryRequest;
use ExpoHub\Http\Requests\DeleteCategoryRequest;
use ExpoHub\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use ExpoHub\Repositories\Contracts\CategoryRepository;
use ExpoHub\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
	public function __construct(CategoryRepository $categoryRepository, Manager $fractal,
								JsonApiSerializer $serializer, CategoryTransformer $categoryTransformer)
	{
		parent::__construct($fractal, $serializer, $categoryTransformer);
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * Returns a list of categories
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->categoryRepository, $request);
		return $this->respondJson($this->categoryRepository->all());
	}

	/**
	 * Returns specified category
	 *
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->categoryRepository, $request);
		return $this->respondJson($this->categoryRepository->find($id));
	}

	/**
	 * Creates category in the database
	 *
	 * @param CreateCategoryRequest $request
	 * @return JsonResponse
	 */
	public function store(CreateCategoryRequest $request)
	{
		$this->setStatus(Response::HTTP_CREATED);
		return $this->respondJson(
			$this->categoryRepository->create($request->only('name', 'fair_id'))
		);
	}

	/**
	 * Updates category
	 *
	 * @param UpdateCategoryRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateCategoryRequest $request, $id)
	{
		return $this->respondJson(
			$this->categoryRepository->update($id, $request->only('name', 'fair_id'))
		);
	}

	/**
	 * Deletes category
	 *
	 * @param DeleteCategoryRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteCategoryRequest $request, $id)
	{
		$this->categoryRepository->delete($id);
		return $this->respondNoContent();
	}

	/**
	 * Returns a list of categories by fair
	 *
	 * @param Request $request
	 * @param $fairId
	 * @return JsonResponse
	 */
	public function getByFair(Request $request, $fairId)
	{
		$this->prepareRepo($this->categoryRepository, $request);
		return $this->respondJson($this->categoryRepository->getByFair($fairId));
	}
}