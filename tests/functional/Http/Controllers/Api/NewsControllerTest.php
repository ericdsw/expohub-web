<?php

use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\NewsRepository;

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
	public function it_creates_news()
	{
		$parameters = [
			'title' => 'foo',
			'content' => 'bar',
			'fair_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->mock(FileManager::class)
			->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile)
			->once();

		$this->call('POST', 'api/v1/news', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_fails_creating_news_with_incorrect_parameters()
	{
		$parameters = [
			// Missing Title
			'content' => 'bar',
			'fair_id' => 1
		];

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

		$this->call('PUT', 'api/v1/news/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'news']);
	}

	/** @test */
	public function it_fails_updating_news_with_incorrect_parameters()
	{
		$parameters = [
			// No Title
			'content' => 'bar',
		];

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

		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/news/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_specified_news()
	{
		$this->mock(FileManager::class)
			->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/news/1');

		$this->assertResponseStatus(204);
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