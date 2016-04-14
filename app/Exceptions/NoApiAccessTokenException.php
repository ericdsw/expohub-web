<?php
namespace ExpoHub\Exceptions;

class NoApiAccessTokenException extends \Exception
{
	public function __construct($message = 'no api token provided')
	{
		parent::__construct($message);
	}
}