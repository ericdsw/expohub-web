<?php
namespace ExpoHub\AccessControllers;

use ExpoHub\Constants\UserType;
use Tymon\JWTAuth\JWTAuth;

class EventTypeAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/**
	 * EventTypeAccessController constructor
	 *
	 * @param JWTAuth $jwtAuth
	 */
	public function __construct(JWTAuth $jwtAuth)
	{
		$this->jwtAuth = $jwtAuth;
	}

	/**
	 * Checks if request can create an eventType
	 *
	 * @return bool
	 */
	public function canCreateEventType()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * Checks if request can update the specified eventType
	 *
	 * @return bool
	 */
	public function canUpdateEventType()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}

	/**
	 * Checks if request can delete the specified eventType
	 *
	 * @return bool
	 */
	public function canDeleteEventType()
	{
		return $this->jwtAuth->parseToken()->toUser()->user_type == UserType::TYPE_ADMIN;
	}
}
