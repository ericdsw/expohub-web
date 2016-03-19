<?php

namespace ExpoHub\AccessControllers;


use Tymon\JWTAuth\JWTAuth;

class FairAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/**
	 * FairAccessController constructor.
	 * @param JWTAuth $JWTAuth
	 */
	public function __construct(JWTAuth $JWTAuth)
	{
		$this->jwtAuth = $JWTAuth;
	}

	/**
	 * @param $fairId
	 * @return boolean
	 */
	public function canUpdateFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}

	/**
	 * @param $fairId
	 * @return boolean
	 */
	public function canDeleteFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}
}