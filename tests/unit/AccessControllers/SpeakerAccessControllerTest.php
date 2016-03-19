<?php

use ExpoHub\AccessControllers\SpeakerAccessController;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\Repositories\Contracts\SpeakerRepository;
use ExpoHub\Speaker;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class SpeakerAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var Mock|SpeakerRepository */
	private $speakerRepository;

	/** @var SpeakerAccessController */
	private $speakerAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->speakerRepository = $this->mock(SpeakerRepository::class);

		$this->speakerAccessController = new SpeakerAccessController(
			$this->jwtAuth, $this->speakerRepository
		);
	}

	/** @test */
	public function it_returns_true_if_user_can_create_speaker_for_specified_fair()
	{
		$fair = new Fair;
		$fair->id = 1;

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([$fair]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->speakerAccessController->canCreateSpeakerForFair($fair->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_create_speaker_for_specified_fair()
	{
		$fair = new Fair;
		$fair->id = 1;

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->speakerAccessController->canCreateSpeakerForFair($fair->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_speaker()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

		$speaker = new Speaker;
		$speaker->id = 3;
		$speaker->fair_event_id = $fairEvent->id;
		$speaker->setRelation('fairEvent', $fairEvent);

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([$fair]));

		$this->speakerRepository->shouldReceive('find')
			->with($speaker->id)
			->once()
			->andReturn($speaker);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->speakerAccessController->canUpdateSpeaker($speaker->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_update_speaker()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

		$speaker = new Speaker;
		$speaker->id = 3;
		$speaker->fair_event_id = $fairEvent->id;
		$speaker->setRelation('fairEvent', $fairEvent);

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([]));

		$this->speakerRepository->shouldReceive('find')
			->with($speaker->id)
			->once()
			->andReturn($speaker);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->speakerAccessController->canUpdateSpeaker($speaker->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_delete_speaker()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

		$speaker = new Speaker;
		$speaker->id = 3;
		$speaker->fair_event_id = $fairEvent->id;
		$speaker->setRelation('fairEvent', $fairEvent);

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([$fair]));

		$this->speakerRepository->shouldReceive('find')
			->with($speaker->id)
			->once()
			->andReturn($speaker);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->speakerAccessController->canDeleteSpeaker($speaker->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_delete_speaker()
	{
		$fair = new Fair;
		$fair->id = 1;

		$fairEvent = new FairEvent;
		$fairEvent->fair_id = $fair->id;
		$fairEvent->setRelation('fair', $fair);

		$speaker = new Speaker;
		$speaker->id = 3;
		$speaker->fair_event_id = $fairEvent->id;
		$speaker->setRelation('fairEvent', $fairEvent);

		$user = new User;
		$user->id = 2;
		$user->setRelation('fairs', collect([]));

		$this->speakerRepository->shouldReceive('find')
			->with($speaker->id)
			->once()
			->andReturn($speaker);

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->speakerAccessController->canDeleteSpeaker($speaker->id);

		$this->assertFalse($result);
	}
}