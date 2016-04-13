<?php

use ExpoHub\AccessControllers\CommentAccessController;
use ExpoHub\Repositories\Contracts\CommentRepository;
use ExpoHub\Specifications\CategorySpecification;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(CommentRepository::class, new StubCommentRepository);
	}

	/** @test */
	public function it_shows_a_list_of_comments()
	{
		$this->get('api/v1/comments');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comments']);
	}

	/** @test */
	public function it_shows_specified_comment()
	{
		$this->get('api/v1/comments/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comments']);
	}

	/** @test */
	public function it_shows_specific_comment_with_includes()
	{
		$includes = 'user,news';

		$this->get('api/v1/comments/1?include=' . $includes);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comments']);
		$this->seeJsonContains(['type' => 'users']);
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_returns_not_found_if_comment_does_not_exists()
	{
		$this->mock(CommentRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/comments/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_comment()
	{
		$parameters = [
			'text' => 'foo',
			'news_id' => 2
		];

		$this->loginForApi();

		$this->post('api/v1/comments', $parameters);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comments']);
	}

	/** @test */
	public function it_wont_create_comment_with_invalid_parameters()
	{
		$parameters = [
			// Missing text parameter
			'news_id' => 2
		];

		$this->loginForApi();

		$this->post('api/v1/comments', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_wont_create_comment_for_not_logged_users()
	{
		$parameters = [
			'text' => 'foo',
			'news_id' => 2
		];

		$this->post('api/v1/comments', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_comment_for_users_with_expired_session()
	{
		$parameters = [
			'text' => 'foo',
			'news_id' => 2
		];

		$this->loginForApiWithExpiredToken();

		$this->post('api/v1/comments', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_updates_existing_comment()
	{
		$parameters = ['text' => 'foo'];

		$this->loginForApi();

		$this->mock(CommentAccessController::class)->shouldReceive('canUpdateComment')
			->with(1)
			->once()
			->andReturn(true);

		$this->put('api/v1/comments/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comments']);
	}

	/** @test */
	public function it_returns_unauthorized_on_update_comment_if_user_cannot_update_comment()
	{
		$parameters = ['text' => 'foo'];

		$this->loginForApi();

		$this->mock(CommentAccessController::class)->shouldReceive('canUpdateComment')
			->with(1)
			->once()
			->andReturn(false);

		$this->put('api/v1/comments/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_comment_for_not_logged_users()
	{
		$parameters = ['text' => 'foo'];

		$this->put('api/v1/comments/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_comment_for_users_with_expired_session()
	{
		$parameters = ['text' => 'foo'];

		$this->loginForApiWithExpiredToken();

		$this->put('api/v1/comments/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_deletes_specified_comment()
	{
		$this->loginForApi();

		$this->mock(CommentAccessController::class)->shouldReceive('canDeleteComment')
			->with(1)
			->once()
			->andReturn(true);

		$this->delete('api/v1/comments/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_on_delete_comment_if_user_does_not_own_it()
	{
		$this->loginForApi();

		$this->mock(CommentAccessController::class)->shouldReceive('canDeleteComment')
			->with(1)
			->once()
			->andReturn(false);

		$this->delete('api/v1/comments/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_comment_for_not_logged_users()
	{
		$this->delete('api/v1/comments/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_comment_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/comments/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_shows_a_list_of_comments_by_user()
	{
		$this->get('api/v1/users/1/comments');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comments']);
	}

	/** @test */
	public function it_shows_a_list_of_comments_by_news()
	{
		$this->get('api/v1/news/1/comments');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comments']);
	}
}