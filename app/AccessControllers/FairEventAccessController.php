<?php
namespace ExpoHub\AccessControllers;

use ExpoHub\Repositories\Contracts\FairEventRepository;
use Tymon\JWTAuth\JWTAuth;

class FairEventAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/** @var FairEventRepository */
	private $fairEventRepository;

	/**
	 * FairEventAccessController constructor
	 *
	 * @param JWTAuth $jwtAuth
	 * @param FairEventRepository $fairEventRepository
	 */
	public function __construct(JWTAuth $jwtAuth, FairEventRepository $fairEventRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->fairEventRepository = $fairEventRepository;
	}

	/**
	 * Checks if request can create a new fairEvent for specified fair
	 *
	 * @param int $fairId
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateFairEventForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()
			->fairs->contains('id', $fairId);
	}

	/**
	 * Checks if request can update specified fairEvent
	 *
	 * @param int $fairEventId
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateFairEvent($fairEventId)
	{
		$fairId = $this->fairEventRepository->find($fairEventId)->fair_id;
		$user 	= $this->jwtAuth->parseToken()->toUser();

		return ($user->fairs->lists('id')->contains($fairId) || $user->helpingFairs->lists('id')->contains($fairId));
	}

	/**
	 * Checks if request can delete specified fairEvent
	 *
	 * @param int $fairEventId
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canDeleteFairEvent($fairEventId)
	{
		$fairId = $this->fairEventRepository->find($fairEventId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}
}
