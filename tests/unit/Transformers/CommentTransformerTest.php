<?php


use ExpoHub\Comment;
use ExpoHub\Transformers\CommentTransformer;

class CommentTransformerTest extends TestCase
{
	/** @var CommentTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new CommentTransformer;
	}

	/** @test */
	public function it_transforms_comment()
	{
		$comment = $this->makeComment();

		$transformedArray = $this->transformer->transform($comment);

		$this->assertEquals([
			'id' => 1,
			'text' => 'comment-text'
		], $transformedArray);
	}

	/**
	 * @return Comment
	 */
	private function makeComment()
	{
		$comment = new Comment;
		$comment->id = 1;
		$comment->text = 'comment-text';

		return $comment;
	}
}