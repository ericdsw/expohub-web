<?php
namespace ExpoHub\AccessControllers;

use ExpoHub\Repositories\Contracts\SpeakerRepository;
use Tymon\JWTAuth\JWTAuth;

class SpeakerAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/** @var SpeakerRepository */
	private $speakerRepository;

	/**
	 * SpeakerAccessController constructor.
	 *
	 * @param JWTAuth $jwtAuth
	 * @param SpeakerRepository $speakerRepository
	 */
	public function __construct(JWTAuth $jwtAuth, SpeakerRepository $speakerRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->speakerRepository = $speakerRepository;
	}

	/**
	 * Checks if request can create speaker for specified fair
	 *
	 * @param int $fairId
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateSpeakerForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs
			->contains('id', $fairId);
	}

	/**
	 * Checks if request can update specified speaker
	 *
	 * @param int $speakerId
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateSpeaker($speakerId)
	{
		$fairId = $this->speakerRepository->find($speakerId)->fairEvent->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}

	/**
	 * Checks if request can delete specified speaker
	 *
	 * @param int $speakerId
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canDeleteSpeaker($speakerId)
	{
		$fairId = $this->speakerRepository->find($speakerId)->fairEvent->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}
}
