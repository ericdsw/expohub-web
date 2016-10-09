<?php
namespace ExpoHub\AccessControllers;

use ExpoHub\Constants\UserType;
use Tymon\JWTAuth\JWTAuth;

class ApiTokenAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/**
	 * ApiTokenAccessController constructor
	 *
	 * @param JWTAuth $jwtAuth
	 */
	public function __construct(JWTAuth $jwtAuth)
	{
		$this->jwtAuth = $jwtAuth;
	}

	/**
	 * Checks if request can list ApiTokens
	 *
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canListApiTokens()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * Checks if request can show specific ApiToken
	 *
	 * @return bool
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canShowApiToken()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}
}
