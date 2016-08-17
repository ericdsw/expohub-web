<?php
namespace ExpoHub\Exceptions;

class NoApiAccessTokenException extends \Exception
{
	/**
	 * NoApiAccessTokenException constructor
	 *
	 * @param string $message
	 */
	public function __construct($message = 'no api token provided')
	{
		parent::__construct($message);
	}
}
