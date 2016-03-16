<?php

namespace ExpoHub\Repositories\Eloquent;

use ExpoHub\Repositories\Contracts\UserRepository as UserRepositoryContract;
use ExpoHub\User;

class UserRepository extends Repository implements UserRepositoryContract
{
	/**
	 * UserRepository constructor.
	 * @param User $model
	 */
	public function __construct(User $model)
	{
		parent::__construct($model);
	}

	/**
	 * Gets user by username
	 *
	 * @param $username
	 * @return User
	 */
	public function getByUsername($username)
	{
		return $this->prepareQuery()->where('username', $username)->first();
	}

	/**
	 * Gets user by email
	 *
	 * @param $email
	 * @return User
	 */
	public function getByEmail($email)
	{
		return $this->prepareQuery()->where('email', $email)->first();
	}
}