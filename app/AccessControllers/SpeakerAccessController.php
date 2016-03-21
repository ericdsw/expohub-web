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
	 * @param JWTAuth $jwtAuth
	 * @param SpeakerRepository $speakerRepository
	 */
	public function __construct(JWTAuth $jwtAuth, SpeakerRepository $speakerRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->speakerRepository = $speakerRepository;
	}

	/**
	 * @param $fairId
	 * @return mixed
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateSpeakerForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs
			->contains('id', $fairId);
	}

	/**
	 * @param $speakerId
	 * @return mixed
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateSpeaker($speakerId)
	{
		$fairId = $this->speakerRepository->find($speakerId)->fairEvent->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}

	/**
	 * @param $speakerId
	 * @return mixed
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canDeleteSpeaker($speakerId)
	{
		$fairId = $this->speakerRepository->find($speakerId)->fairEvent->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}
}