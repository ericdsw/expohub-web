<?php

use ExpoHub\Comment;
use ExpoHub\News;
use ExpoHub\Repositories\Contracts\CommentRepository;
use ExpoHub\User;

class StubCommentRepository implements CommentRepository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \ExpoHub\Comment
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createComment();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \ExpoHub\Comment
	 */
	public function create(array $parameters)
	{
		return $this->createComment();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \ExpoHub\Comment
	 */
	public function update($id, array $parameters)
	{
		return $this->createComment();
	}

	/**
	 * Returns comments for the specified news
	 *
	 * @param $newsId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getByNews($newsId)
	{
		return collect([$this->createComment()]);
	}

	/**
	 * Returns comments for the specified users
	 *
	 * @param $userId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getByUser($userId)
	{
		return collect([$this->createComment()]);
	}

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createComment()]);
	}

	/**
	 * Deletes specified resource
	 *
	 * @param  int $id
	 * @return int
	 */
	public function delete($id)
	{
		return collect([$this->createComment()]);
	}

	/**
	 * @return Comment
	 */
	private function createComment()
	{
		$comment = new Comment;

		// OverWrite date format
		$comment->setDateFormat('Y');

		// Parameters
		$comment->text = "foo";

		// Relationships
		$comment->setRelation('user', new User);
		$comment->setRelation('ownerNews', collect([new News]));

		return $comment;
	}

	/**
	 * Prepares eager loading for consulting queries
	 *
	 * @param array $eagerLoading
	 */
	public function prepareEagerLoading(array $eagerLoading)
	{
		//
	}

	/**
	 * Prepares result order for consulting queries
	 *
	 * @param $parameter
	 * @param $order
	 */
	public function prepareOrderBy($parameter, $order)
	{
		//
	}
}