<?php

use ExpoHub\Repositories\Contracts\CommentRepository;

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
		$this->seeJsonContains(['type' => 'comment']);
	}

	/** @test */
	public function it_shows_specified_comment()
	{
		$this->get('api/v1/comments/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comment']);
	}

	/** @test */
	public function it_shows_specific_comment_with_includes()
	{
		$includes = 'user,news';

		$this->get('api/v1/comments/1?include=' . $includes);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comment']);
		$this->seeJsonContains(['type' => 'user']);
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_stores_comment()
	{
		$this->post('api/v1/comments', $this->createValidStoreRequest());

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comment']);
	}

	/** @test */
	public function it_updates_existing_comment()
	{
		$this->put('api/v1/comments/1', $this->createValidUpdateRequest());

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comment']);
	}

	/** @test */
	public function it_deletes_specified_comment()
	{
		$this->delete('api/v1/comments/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_shows_a_list_of_comments_by_user()
	{
		$this->get('api/v1/users/1/comments');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comment']);
	}

	/** @test */
	public function it_shows_a_list_of_comments_by_news()
	{
		$this->get('api/v1/news/1/comments');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'comment']);
	}

	/**
	 * @return array
	 */
	private function createValidStoreRequest()
	{
		return [
			'name' => 'foo',
			'news_id' => 2,
			'use_id' => 3
		];
	}

	/**
	 * @return array
	 */
	private function createValidUpdateRequest()
	{
		return ['name' => 'foo'];
	}
}