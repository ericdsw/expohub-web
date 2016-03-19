<?php

use ExpoHub\AccessControllers\CommentAccessController;
use ExpoHub\Comment;
use ExpoHub\Constants\UserType;
use ExpoHub\Fair;
use ExpoHub\News;
use ExpoHub\Repositories\Contracts\CommentRepository;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class CommentAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var Mock|CommentRepository */
	private $commentRepository;

	/** @var CommentAccessController */
	private $commentAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->commentRepository = $this->mock(CommentRepository::class);

		$this->commentAccessController = new CommentAccessController(
			$this->jwtAuth, $this->commentRepository
		);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_comment()
	{
		$comment = new Comment;
		$comment->id = 2;

		$user = new User;
		$user->id = 1;
		$user->setRelation('comments', collect([$comment]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->commentAccessController->canUpdateComment($comment->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_update_comment()
	{
		$comment = new Comment;
		$comment->id = 2;

		$user = new User;
		$user->id = 1;
		$user->setRelation('comments', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->commentAccessController->canUpdateComment($comment->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_creator_can_delete_comment()
	{
		$fair = new Fair;
		$fair->id = 4;

		$news = new News;
		$news->id = 3;
		$news->fair_id = $fair->id;
		$news->setRelation('fair', $fair);

		$comment = new Comment;
		$comment->id = 2;
		$comment->news_id = $news->id;
		$comment->setRelation('ownerNews', $news);

		// User owns comment
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_USER;
		$user->setRelation('comments', collect([$comment]));
		$user->setRelation('fairs', collect([]));

		$this->commentRepository->shouldReceive('find')
			->with($comment->id)
			->once()
			->andReturn($comment);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->commentAccessController->canDeleteComment($comment->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_true_if_user_is_admin_for_can_delete_comment()
	{
		$fair = new Fair;
		$fair->id = 4;

		$news = new News;
		$news->id = 3;
		$news->fair_id = $fair->id;
		$news->setRelation('fair', $fair);

		$comment = new Comment;
		$comment->id = 2;
		$comment->news_id = $news->id;
		$comment->setRelation('ownerNews', $news);

		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_ADMIN;
		$user->setRelation('comments', collect([]));
		$user->setRelation('fairs', collect([]));

		$this->commentRepository->shouldReceive('find')
			->with($comment->id)
			->once()
			->andReturn($comment);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->commentAccessController->canDeleteComment($comment->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_true_if_user_owns_fair_for_can_delete_comment()
	{
		$fair = new Fair;
		$fair->id = 4;

		$news = new News;
		$news->id = 3;
		$news->fair_id = $fair->id;
		$news->setRelation('fair', $fair);

		$comment = new Comment;
		$comment->id = 2;
		$comment->news_id = $news->id;
		$comment->setRelation('ownerNews', $news);

		// User owns fair
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_USER;
		$user->setRelation('comments', collect([]));
		$user->setRelation('fairs', collect([$fair]));

		$this->commentRepository->shouldReceive('find')
			->with($comment->id)
			->once()
			->andReturn($comment);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->commentAccessController->canDeleteComment($comment->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_delete_comment()
	{
		$fair = new Fair;
		$fair->id = 4;

		$news = new News;
		$news->id = 3;
		$news->fair_id = $fair->id;
		$news->setRelation('fair', $fair);

		$comment = new Comment;
		$comment->id = 2;
		$comment->news_id = $news->id;
		$comment->setRelation('ownerNews', $news);

		// User owns comment
		$user = new User;
		$user->id = 1;
		$user->user_type = UserType::TYPE_USER;
		$user->setRelation('comments', collect([]));
		$user->setRelation('fairs', collect([]));

		$this->commentRepository->shouldReceive('find')
			->with($comment->id)
			->once()
			->andReturn($comment);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->commentAccessController->canDeleteComment($comment->id);

		$this->assertFalse($result);
	}
}