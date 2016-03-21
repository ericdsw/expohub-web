<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Http\Controllers\Api\ApiController;
use ExpoHub\Http\Requests\CreateCommentRequest;
use ExpoHub\Http\Requests\DeleteCommentRequest;
use ExpoHub\Http\Requests\UpdateCommentRequest;
use ExpoHub\Repositories\Contracts\CommentRepository;
use ExpoHub\Transformers\CommentTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use Tymon\JWTAuth\JWTAuth;

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
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->commentRepository, $request);
		return $this->respondJson($this->commentRepository->all());
	}

	/**
	 * Returns specified comment
	 *
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->commentRepository, $request);
		return $this->respondJson($this->commentRepository->find($id));
	}

	/**
	 * Creates comment
	 *
	 * @param JWTAuth $jwtAuth
	 * @param CreateCommentRequest $request
	 * @return JsonResponse
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function store(JWTAuth $jwtAuth, CreateCommentRequest $request)
	{
		$this->setStatus(Response::HTTP_CREATED);
		$parameters = $request->only('text', 'news_id');
		return $this->respondJson(
			$this->commentRepository->create(array_merge($parameters, [
				'user_id' => $jwtAuth->parseToken()->toUser()->id
			]))
		);
	}

	/**
	 * Updates existing comment
	 *
	 * @param UpdateCommentRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateCommentRequest $request, $id)
	{
		$currentComment = $this->commentRepository->find($id);
		return $this->respondJson(
			$this->commentRepository->update($id, [
				'name' => $request->has('text') ? $request->get('text') : $currentComment->text
			])
		);
	}

	/**
	 * Destroys existing comment
	 *
	 * @param DeleteCommentRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteCommentRequest $request, $id)
	{
		$this->commentRepository->delete($id);
		return $this->respondNoContent();
	}

	/**
	 * Returns a list of comments by user
	 *
	 * @param Request $request
	 * @param $userId
	 * @return JsonResponse
	 */
	public function getByUser(Request $request, $userId)
	{
		$this->prepareRepo($this->commentRepository, $request);
		return $this->respondJson($this->commentRepository->getByUser($userId));
	}

	/**
	 * Returns a list of comments by news
	 *
	 * @param Request $request
	 * @param $newsId
	 * @return JsonResponse
	 */
	public function getByNews(Request $request, $newsId)
	{
		$this->prepareRepo($this->commentRepository, $request);
		return $this->respondJson($this->commentRepository->getByNews($newsId));
	}
}