<?php

namespace ExpoHub\AccessControllers;

use ExpoHub\Repositories\Contracts\SponsorRepository;
use Tymon\JWTAuth\JWTAuth;

class SponsorAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/** @var SponsorRepository */
	private $sponsorRepository;

	/**
	 * SponsorAccessController constructor.
	 * @param JWTAuth $jwtAuth
	 * @param SponsorRepository $sponsorRepository
	 */
	public function __construct(JWTAuth $jwtAuth, SponsorRepository $sponsorRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->sponsorRepository = $sponsorRepository;
	}

	/**
	 * @param $fairId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateSponsorForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs
			->contains('id', $fairId);
	}

	/**
	 * @param $sponsorId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateSponsor($sponsorId)
	{
		$fairId = $this->sponsorRepository->find($sponsorId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}

	/**
	 * @param $sponsorId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canDeleteSponsorRank($sponsorId)
	{
		$fairId = $this->sponsorRepository->find($sponsorId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}
}