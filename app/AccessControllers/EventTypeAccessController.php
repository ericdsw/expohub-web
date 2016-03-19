<?php

namespace ExpoHub\AccessControllers;

use ExpoHub\Constants\UserType;
use Tymon\JWTAuth\JWTAuth;

class EventTypeAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/**
	 * EventTypeAccessController constructor.
	 * @param JWTAuth $jwtAuth
	 */
	public function __construct(JWTAuth $jwtAuth)
	{
		$this->jwtAuth = $jwtAuth;
	}

	/**
	 * @return boolean
	 */
	public function canCreateEventType()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * @return boolean
	 */
	public function canUpdateEventType()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * @return boolean
	 */
	public function canDeleteEventType()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}
}