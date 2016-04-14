<?php
namespace ExpoHub\Exceptions;

class MalformedApiAccessTokenException extends \Exception
{
	public function __construct($message = 'malformed access token')
	{
		parent::__construct($message);
	}
}