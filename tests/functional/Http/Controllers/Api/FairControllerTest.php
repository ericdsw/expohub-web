<?php

use ExpoHub\AccessControllers\FairAccessController;
use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\FairRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FairControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(FairRepository::class, new StubFairRepository);
	}

	/** @test */
	public function it_displays_all_fairs()
	{
		$this->get('api/v1/fairs');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairs']);
	}

	/** @test */
	public function it_displays_specified_fair()
	{
		$this->get('api/v1/fairs/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairs']);
	}

	/** @test */
	public function it_displays_specific_fair_with_includes()
	{
		$includes = 'user,bannedUsers,helperUsers,sponsors,maps,categories,fairEvents,news,stands';

		$this->get('api/v1/fairs/1?include=' . $includes);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairs']);
		$this->seeJsonContains(['type' => 'users']);
		$this->seeJsonContains(['type' => 'sponsors']);
		$this->seeJsonContains(['type' => 'maps']);
		$this->seeJsonContains(['type' => 'categories']);
		$this->seeJsonContains(['type' => 'fairEvents']);
		$this->seeJsonContains(['type' => 'news']);
		$this->seeJsonContains(['type' => 'stands']);
	}

	/** @test */
	public function it_returns_not_found_if_fair_does_not_exists()
	{
		$this->mock(FairRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/fairs/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_fair()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
			'user_id' => 1,
		];

		$this->loginForApi();

		$file = $this->generateStubUploadedFile();

		$fileManager = $this->mock(FileManager::class);
		$fileManager->shouldReceive('uploadFile')
			->with('uploads/', $file)
			->once();

		$this->call('POST', 'api/v1/fairs', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairs']);
	}

	/** @test */
	public function it_wont_create_fair_for_not_logged_users()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
			'user_id' => 1,
		];

		$file = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/fairs', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_fair_for_users_with_expired_session()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
			'user_id' => 1,
		];

		$this->loginForApiWithExpiredToken();

		$file = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/fairs', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_creating_fair_with_invalid_parameters()
	{
		$parameters = [
			// Missing the 'name' parameter, which is required
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
			'user_id' => 1,
		];

		$this->loginForApi();

		$file = $this->generateStubUploadedFile();
		$this->call('POST', 'api/v1/fairs', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_creating_fair_with_invalid_image()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
			'user_id' => 1,
		];

		$image = $this->generateInvalidStubUploadedFile();

		$this->loginForApi();

		$this->call('POST', 'api/v1/fairs', $parameters, [], ['image' => $image]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_existing_fair_with_image()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$this->loginForApi();

		$this->mock(FairAccessController::class)
			->shouldReceive('canUpdateFair')
			->with(1)
			->once()
			->andReturn(true);

		$file = $this->generateStubUploadedFile();

		$fileManager = $this->mock(FileManager::class);
		$fileManager->shouldReceive('deleteFile');
		$fileManager->shouldReceive('uploadFile')
			->with('uploads/', $file)
			->once();

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairs']);
	}

	/** @test */
	public function it_updates_existing_fair_without_image()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$this->loginForApi();

		$this->mock(FairAccessController::class)
			->shouldReceive('canUpdateFair')
			->with(1)
			->once()
			->andReturn(true);

		$this->mock(FileManager::class);

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], []);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairs']);
	}

	/** @test */
	public function it_fails_update_existing_fair_with_invalid_parameters()
	{
		$parameters = [
			'latitude' 	=> 'foo',
			'longitude' => 'bar',
		];

		$this->loginForApi();

		$this->mock(FairAccessController::class)
			->shouldReceive('canUpdateFair')
			->with(1)
			->once()
			->andReturn(true);

		$file = $this->generateStubUploadedFile();
		$this->mock(FileManager::class);

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_update_existing_fair_with_invalid_images()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$this->loginForApi();

		$this->mock(FairAccessController::class)
			->shouldReceive('canUpdateFair')
			->with(1)
			->once()
			->andReturn(true);

		$file = $this->generateInvalidStubUploadedFile();
		$this->mock(FileManager::class);

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_does_not_own_fair()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$this->loginForApi();

		$this->mock(FairAccessController::class)
			->shouldReceive('canUpdateFair')
			->with(1)
			->once()
			->andReturn(false);

		$file = $this->generateStubUploadedFile();

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_fair_for_not_logged_in_users()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$file = $this->generateStubUploadedFile();

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_fair_for_users_with_expired_token()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$this->loginForApiWithExpiredToken();

		$file = $this->generateStubUploadedFile();

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_deletes_existing_fair()
	{
		$this->loginForApi();

		$this->mock(FairAccessController::class)
			->shouldReceive('canDeleteFair')
			->with(1)
			->once()
			->andReturn(true);

		$this->mock(FileManager::class)->shouldReceive('deleteFile');

		$this->delete('api/v1/fairs/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_on_delete_fair_if_user_does_not_own_fair()
	{
		$this->loginForApi();

		$this->mock(FairAccessController::class)
			->shouldReceive('canDeleteFair')
			->with(1)
			->once()
			->andReturn(false);

		$this->mock(FileManager::class)->shouldReceive('deleteFile');

		$this->delete('api/v1/fairs/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_fair_for_not_logged_users()
	{
		$this->mock(FileManager::class)->shouldReceive('deleteFile');

		$this->delete('api/v1/fairs/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_fair_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->mock(FileManager::class)->shouldReceive('deleteFile');

		$this->delete('api/v1/fairs/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_displays_all_active_fairs()
	{
		$this->get('api/v1/fairs/active');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairs']);
	}

	/** @test */
	public function it_displays_all_fairs_by_users()
	{
		$this->geT('api/v1/users/1/fairs');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairs']);
	}
}
