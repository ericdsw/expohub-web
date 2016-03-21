<?php

namespace ExpoHub\AccessControllers;


use ExpoHub\Repositories\Contracts\StandRepository;
use Tymon\JWTAuth\JWTAuth;

class StandAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/** @var StandRepository */
	private $standRepository;

	/**
	 * StandAccessController constructor.
	 * @param JWTAuth $jwtAuth
	 * @param StandRepository $standRepository
	 */
	public function __construct(JWTAuth $jwtAuth, StandRepository $standRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->standRepository = $standRepository;
	}

	/**
	 * @param $fairId
	 * @return mixed
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateStandForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs
			->contains('id', $fairId);
	}

	/**
	 * @param $standId
	 * @return mixed
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateStand($standId)
	{
		$fairId = $this->standRepository->find($standId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}

	public function canDeleteStand($standId)
	{
		$fairId = $this->standRepository->find($standId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}
}