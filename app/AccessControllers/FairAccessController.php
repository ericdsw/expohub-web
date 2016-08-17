<?php
namespace ExpoHub\AccessControllers;

use Tymon\JWTAuth\JWTAuth;

class FairAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/**
	 * FairAccessController constructor
	 *
	 * @param JWTAuth $JWTAuth
	 */
	public function __construct(JWTAuth $JWTAuth)
	{
		$this->jwtAuth = $JWTAuth;
	}

	/**
	 * Checks if request can update specified fair
	 *
	 * @param int $fairId
	 * @return bool
	 */
	public function canUpdateFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}

	/**
	 * Checks if request can delete specified fair
	 *
	 * @param $fairId
	 * @return boolean
	 */
	public function canDeleteFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}
}
