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
		$comment = new Comment;
		$comment->id = 1;
		$comment->text = 'foo';

		$transformedArray = $this->transformer->transform($comment);

		$this->assertEquals(1, $transformedArray['id']);
		$this->assertEquals('foo', $transformedArray['text']);
	}
}