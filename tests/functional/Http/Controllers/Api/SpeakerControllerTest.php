<?php
use ExpoHub\AccessControllers\SpeakerAccessController;
use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\SpeakerRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Created by PhpStorm.
 * User: Eric De Sedas
 * Date: 3/6/16
 * Time: 10:05 PM
 */
class SpeakerControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(SpeakerRepository::class, new StubSpeakerRepository);
	}

	/** @test */
	public function it_displays_al_speakers()
	{
		$this->get('api/v1/speakers');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'speaker']);
	}

	/** @test */
	public function it_displays_specific_speaker()
	{
		$this->get('api/v1/speakers/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'speaker']);
	}

	/** @test */
	public function it_displays_specific_speaker_with_includes()
	{
		$includeString = 'fairEvent';

		$this->get('api/v1/speakers/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'speaker']);
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_returns_not_found_if_speaker_does_not_exists()
	{
		$this->mock(SpeakerRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/speakers/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_speaker()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_event_id' => 1
		];

		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canCreateSpeakerForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->mock(FileManager::class)->shouldReceive('uploadFile')
			->with('uploads/', $uploadedFile)
			->once();

		$this->call('POST', 'api/v1/speakers', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'speaker']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_create_speaker()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_event_id' => 1
		];

		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canCreateSpeakerForFair')
			->with(1)
			->once()
			->andReturn(false);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/speakers', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_speaker_for_not_logged_users()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_event_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/speakers', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_speaker_for_users_with_expired_session()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_event_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->loginForApiWithExpiredToken();

		$this->call('POST', 'api/v1/speakers', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_creating_speaker_with_invalid_parameters()
	{
		$parameters = [
			// Missing name
			'description' => 'bar',
			'fair_event_id' => 1
		];

		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canCreateSpeakerForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/speakers', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_creating_speaker_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_event_id' => 1
		];

		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canCreateSpeakerForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('POST', 'api/v1/speakers', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_speaker_with_image()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canUpdateSpeaker')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();
		$fileManager = $this->mock(FileManager::class);

		$fileManager->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$fileManager->shouldReceive('uploadFile')
			->with('uploads/', $uploadedFile)
			->once();

		$this->call('PUT', 'api/v1/speakers/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'speaker']);
	}

	/** @test */
	public function it_updates_speaker_without_image()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canUpdateSpeaker')
			->with(1)
			->once()
			->andReturn(true);

		$this->call('PUT', 'api/v1/speakers/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'speaker']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_update_speaker()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canUpdateSpeaker')
			->with(1)
			->once()
			->andReturn(false);

		$this->call('PUT', 'api/v1/speakers/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_speaker_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->call('PUT', 'api/v1/speakers/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_speaker_if_user_has_expired_session()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApiWithExpiredToken();

		$this->call('PUT', 'api/v1/speakers/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_updating_speaker_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canUpdateSpeaker')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/speakers/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_speaker()
	{
		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canDeleteSpeaker')
			->with(1)
			->once()
			->andReturn(true);

		$this->mock(FileManager::class)->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/speakers/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_delete_speaker()
	{
		$this->loginForApi();

		$this->mock(SpeakerAccessController::class)
			->shouldReceive('canDeleteSpeaker')
			->with(1)
			->once()
			->andReturn(false);

		$this->delete('api/v1/speakers/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_speaker_for_not_logged_in_user()
	{
		$this->delete('api/v1/speakers/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_speaker_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/speakers/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_displays_speakers_by_fair_event()
	{
		$this->get('api/v1/fairEvents/1/speakers');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'speaker']);
	}
}