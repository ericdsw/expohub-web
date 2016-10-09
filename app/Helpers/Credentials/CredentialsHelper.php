<?php
namespace ExpoHub\Helpers\Credentials;

use ExpoHub\Helpers\Credentials\Contracts\CredentialsHelper as CredentialsHelperContract;

class CredentialsHelper implements CredentialsHelperContract
{
	/**
	 * Decides if the user is attempting to authenticate with an
	 * email or with a username.
	 *
	 * @param $value string
	 * @return string - username|email
	 */
	public function getLoginField($value)
	{
		$field = filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		return $field;
	}
}
