<?php
namespace ExpoHub\Exceptions;

class MalformedApiAccessTokenException extends \Exception
{
	/**
	 * MalformedApiAccessControllerException constructor
	 *
	 * @param string $message
	 */
	public function __construct($message = 'malformed access token')
	{
		parent::__construct($message);
	}
}
