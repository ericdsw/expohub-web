<?php

use ExpoHub\AccessControllers\NewsAccessController;
use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\NewsRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NewsControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(NewsRepository::class, new StubNewsRepository);
	}

	/** @test */
	public function it_displays_all_news()
	{
		$this->get('api/v1/news');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_displays_specific_news()
	{
		$this->get('api/v1/news/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_displays_specific_news_with_includes()
	{
		$includeString = 'fair,comments';

		$this->get('api/v1/news/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
		$this->seeJsonContains(['type' => 'fair']);
		$this->seeJsonContains(['type' => 'comment']);
	}

	/** @test */
	public function it_returns_not_found_if_news_does_not_exists()
	{
		$this->mock(NewsRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/news/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_news()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canCreateNewsForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->mock(FileManager::class)
			->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile)
			->once();

		$this->call('POST', 'api/v1/news', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_create_news()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canCreateNewsForFair')
			->with(1)
			->once()
			->andReturn(false);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/news', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_news_for_not_logged_in_user()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
			'fair_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/news', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_fails_creating_news_with_incorrect_parameters()
	{
		$parameters = [
			// Missing Title
			'content' => 'bar',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canCreateNewsForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/news', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
		$this->seeJson();
	}

	/** @test */
	public function it_fails_creating_news_with_incorrect_image()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canCreateNewsForFair')
			->with(1)
			->once()
			->andReturn(true);

		// Invalid uploaded file
		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('POST', 'api/v1/news', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
		$this->seeJson();
	}

	/** @test */
	public function it_updates_news_with_image()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar'
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canUpdateNews')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();
		$fileManager  = $this->mock(FileManager::class);

		$fileManager->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile)
			->once();
		$fileManager->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->call('PUT', 'api/v1/news/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_updates_news_without_image()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canUpdateNews')
			->with(1)
			->once()
			->andReturn(true);

		$this->call('PUT', 'api/v1/news/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_update_news()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canUpdateNews')
			->with(1)
			->once()
			->andReturn(false);

		$this->call('PUT', 'api/v1/news/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_news_if_user_is_not_logged_in()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
		];

		$this->call('PUT', 'api/v1/news/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_news_if_user_has_expired_session()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
		];

		$this->loginForApiWithExpiredToken();

		$this->call('PUT', 'api/v1/news/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_updating_news_with_incorrect_parameters()
	{
		$parameters = [
			// No Title
			'content' => 'bar',
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canUpdateNews')
			->with(1)
			->once()
			->andReturn(true);

		$this->call('PUT', 'api/v1/news/1', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_updating_news_with_incorrect_image()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar'
		];

		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canUpdateNews')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/news/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_specified_news()
	{
		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canDeleteNews')
			->with(1)
			->once()
			->andReturn(true);

		$this->mock(FileManager::class)
			->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/news/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_delete_news()
	{
		$this->loginForApi();

		$this->mock(NewsAccessController::class)
			->shouldReceive('canDeleteNews')
			->with(1)
			->once()
			->andReturn(false);

		$this->delete('api/v1/news/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_news_for_not_logged_in_users()
	{
		$this->delete('api/v1/news/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_news_for_users_with_expired_sessions()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/news/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_displays_news_by_fair()
	{
		$this->get('api/v1/fairs/1/news');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
	}
}