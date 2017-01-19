<?php
namespace ExpoHub\AccessControllers;

use ExpoHub\Constants\UserType;
use Tymon\JWTAuth\JWTAuth;

class SponsorRankAccessController
{
	/** @var JWTAuth  */
	private $jwtAuth;

	/**
	 * SponsorRankAccessController Constructor
	 *
	 * @param JWTAuth $jwtAuth
	 */
	public function __construct(JWTAuth $jwtAuth)
	{
		$this->jwtAuth = $jwtAuth;
	}

	/**
	 * Checks if request can create sponsor rank
	 *
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateSponsorRank()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * Checks if request can update specified sponsor rank
	 *
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateSponsorRank()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * Checks if request can delete specified sponsor rank
	 *
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canDeleteSponsorRank()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}
}
