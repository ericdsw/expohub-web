<?php

namespace ExpoHub\Transformers;


use ExpoHub\User;

class UserTransformer extends BaseTransformer
{
	/**
	 * Converts User to json
	 *
	 * @param User $user
	 * @return array
	 */
	public function transform(User $user)
	{
		return [
			'id' => (int) $user->id,
			'name' => $user->name,
			'username' => $user->username,
			'email' => $user->email
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'user';
	}
}