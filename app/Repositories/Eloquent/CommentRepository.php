<?php

namespace ExpoHub\Repositories\Eloquent;


use ExpoHub\Comment;
use ExpoHub\Repositories\Contracts\CommentRepository as CommentRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository extends Repository implements CommentRepositoryContract
{
	/**
	 * CommentRepository constructor.
	 * @param Comment $model
	 */
	public function __construct(Comment $model)
	{
		parent::__construct($model);
	}

	/**
	 * Returns comments for the specified news
	 *
	 * @param $newsId
	 * @return Collection
	 */
	public function getByNews($newsId)
	{
		return $this->model->where('news_id', $newsId)->get();
	}

	/**
	 * Returns comments for the specified users
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByUser($userId)
	{
		return $this->model->where('user_id', $userId)->get();
	}
}