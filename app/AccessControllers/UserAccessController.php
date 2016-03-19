<?php

namespace ExpoHub\AccessControllers;


use ExpoHub\Constants\UserType;
use Tymon\JWTAuth\JWTAuth;

class UserAccessController
{
	/** @var JWTAuth  */
	private $jwtAuth;

	public function __construct(JWTAuth $jwtAuth)
	{
		$this->jwtAuth = $jwtAuth;
	}

	/**
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateUser()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateUser()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canDeleteUser()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}
}