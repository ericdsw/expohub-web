<?php
namespace ExpoHub\AccessControllers;


use ExpoHub\Constants\UserType;
use Tymon\JWTAuth\JWTAuth;

class ApiTokenAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/**
	 * ApiTokenAccessController constructor.
	 * @param JWTAuth $jwtAuth
	 */
	public function __construct(JWTAuth $jwtAuth)
	{
		$this->jwtAuth = $jwtAuth;
	}

	/**
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canListApiTokens()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canShowApiToken()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}
}