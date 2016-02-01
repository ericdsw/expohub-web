<?php

namespace integration\Repositories\Eloquent;


use DatabaseCreator;
use ExpoHub\Comment;
use ExpoHub\Repositories\Eloquent\CommentRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TestCase;

class CommentRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var CommentRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new CommentRepository(new Comment);
	}

	/** @test */
	public function it_returns_comments_by_news()
	{
		$creatingUser 	= $this->createUser();
		$commentingUser = $this->createUser();
		$fair 			= $this->createFair($creatingUser->id);
		$news 			= $this->createNews($fair->id);
		$randomNews 	= $this->createNews($fair->id);

		$this->createComment($news->id, $commentingUser->id);		// Valid comment
		$this->createComment($news->id, $creatingUser->id);			// Valid comment
		$this->createComment($randomNews->id, $commentingUser->id);	// Invalid comment, not from news

		$comments = $this->repository->getByNews($news->id);

		$this->assertCount(2, $comments);
	}

	/** @test */
	public function it_returns_comments_by_specified_user()
	{
		$creatingUser 	= $this->createUser();
		$commentingUser = $this->createUser();
		$fair 			= $this->createFair($creatingUser->id);
		$news 			= $this->createNews($fair->id);
		$randomNews 	= $this->createNews($fair->id);

		$this->createComment($news->id, $commentingUser->id);		// Valid comment
		$this->createComment($news->id, $commentingUser->id);		// Valid comment
		$this->createComment($news->id, $creatingUser->id);			// Invalid comment
		$this->createComment($randomNews->id, $commentingUser->id);	// Valid comment

		$comments = $this->repository->getByUser($commentingUser->id);

		$this->assertCount(3, $comments);
	}
}