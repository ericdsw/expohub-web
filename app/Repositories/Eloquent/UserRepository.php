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
}