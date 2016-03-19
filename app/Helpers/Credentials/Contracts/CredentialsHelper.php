<?php

namespace ExpoHub\Helpers\Credentials\Contracts;

interface CredentialsHelper
{
	/**
	 * Decides if the user is attempting to authenticate with an
	 * email or with a username.
	 *
	 * @param $value string
	 * @return string - username|email
	 */
	public function getLoginField($value);
}