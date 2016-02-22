<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Http\Controllers\Api\ApiController;
use ExpoHub\Repositories\Contracts\CommentRepository;
use ExpoHub\Transformers\CommentTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class CommentController extends ApiController
{
	/** @var CommentRepository */
	private $commentRepository;

	/**
	 * CommentController constructor.
	 *
	 * @param CommentRepository $commentRepository
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param CommentTransformer $categoryTransformer
	 */
	public function __construct(CommentRepository $commentRepository, Manager $fractal,
								JsonApiSerializer $serializer, CommentTransformer $categoryTransformer)
	{
		parent::__construct($fractal, $serializer, $categoryTransformer);
		$this->commentRepository = $commentRepository;
	}

	/**
	 * Returns a list of comments
	 *
	 * @return JsonResponse
	 */
	public function index()
	{
		return $this->respondJson($this->commentRepository->all());
	}

	/**
	 * Returns specified comment
	 *
	 * @param $id
	 * @return JsonResponse
	 */
	public function show($id)
	{
		return $this->respondJson($this->commentRepository->find($id));
	}

	/**
	 * Creates comment
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function store(Request $request)
	{
		return $this->respondJson(
			$this->commentRepository->create($request->only('name', 'news_id', 'user_id'))
		);
	}

	/**
	 * Updates existing comment
	 *
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(Request $request, $id)
	{
		return $this->respondJson(
			$this->commentRepository->update($id, $request->only('name'))
		);
	}

	/**
	 * Destroys existing comment
	 *
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy($id)
	{
		$this->commentRepository->delete($id);
		return $this->respondNoContent();
	}

	/**
	 * Returns a list of comments by user
	 *
	 * @param $userId
	 * @return JsonResponse
	 */
	public function getByUser($userId)
	{
		return $this->respondJson($this->commentRepository->getByUser($userId));
	}

	/**
	 * Returns a list of comments by news
	 *
	 * @param $newsId
	 * @return JsonResponse
	 */
	public function getByNews($newsId)
	{
		return $this->respondJson($this->commentRepository->getByNews($newsId));
	}
}