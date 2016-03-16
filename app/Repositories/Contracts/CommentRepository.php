<?php

namespace ExpoHub\Repositories\Contracts;


use ExpoHub\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Comment
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return Comment
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return Comment
	 */
	public function update($id, array $parameters);

	/**
	 * Returns comments for the specified news
	 *
	 * @param $newsId
	 * @return Collection
	 */
	public function getByNews($newsId);

	/**
	 * Returns comments for the specified users
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByUser($userId);
}