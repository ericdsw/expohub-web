<?php

namespace ExpoHub\Transformers;


use ExpoHub\Comment;

class CommentTransformer extends BaseTransformer
{
	public function transform(Comment $comment)
	{
		return [
			'id' => (int) $comment->id,
			'text' => $comment->text,
		];
	}

	public function getType()
	{
		return "comment";
	}
}