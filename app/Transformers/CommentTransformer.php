<?php

namespace ExpoHub\Transformers;


use ExpoHub\Comment;

class CommentTransformer extends BaseTransformer
{
	/**
	 * Convert Comments to valid json representation
	 *
	 * @param Comment $comment
	 * @return array
	 */
	public function transform(Comment $comment)
	{
		return [
			'id' => (int) $comment->id,
			'text' => $comment->text,
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "comment";
	}
}