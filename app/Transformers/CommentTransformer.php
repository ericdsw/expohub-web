<?php
namespace ExpoHub\Transformers;

use ExpoHub\Comment;
use League\Fractal\Resource\Item;

class CommentTransformer extends BaseTransformer
{
	protected $availableIncludes = ['user',
									'ownerNews'];

	/**
	 * Convert Comments to valid json representation
	 *
	 * @param Comment $comment
	 * @return array
	 */
	public function transform(Comment $comment)
	{
		return [
			'id' 	=> (int) $comment->id,
			'text' 	=> $comment->text,
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "comments";
	}

	/**
	 * Includes related User
	 *
	 * @param Comment $comment
	 * @return Item
	 */
	public function includeUser(Comment $comment)
	{
		$user = $comment->user;
		$userTransformer = app()->make(UserTransformer::class);
		return $this->item($user, $userTransformer, $userTransformer->getType());
	}

	/**
	 * Includes related News
	 *
	 * @param Comment $comment
	 * @return Item
	 */
	public function includeOwnerNews(Comment $comment)
	{
		$news = $comment->ownerNews;
		$newsTransformer = app()->make(NewsTransformer::class);
		return $this->item($news, $newsTransformer, $newsTransformer->getType());
	}
}
