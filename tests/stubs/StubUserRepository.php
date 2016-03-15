<?php

use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\Repositories\Contracts\UserRepository;
use ExpoHub\User;
use ExpoHub\Comment;

class StubUserRepository implements UserRepository
{
	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createUser()]);
	}

	/**
	 * Deletes specified resource
	 *
	 * @param  int $id
	 * @return int
	 */
	public function delete($id)
	{
		return 1;
	}

	/**
	 * Prepares eager loading for consulting queries
	 *
	 * @param array $eagerLoading
	 */
	public function prepareEagerLoading(array $eagerLoading)
	{
		//
	}

	/**
	 * Prepares result order for consulting queries
	 *
	 * @param $parameter
	 * @param $order
	 */
	public function prepareOrderBy($parameter, $order)
	{
		//
	}

	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \ExpoHub\User
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createUser();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \ExpoHub\User
	 */
	public function create(array $parameters)
	{
		return $this->createUser();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \ExpoHub\User
	 */
	public function update($id, array $parameters)
	{
		return $this->createUser();
	}

	/**
	 * @return User
	 */
	private function createUser()
	{
		$user = new User;
		$user->id = 1;
		$user->name = "foo";
		$user->username = "bar";
		$user->email = "baz";
		$user->password = "qux";
		$user->remember_token = "foobar";

		$user->setRelation('fairs', collect([new Fair]));
		$user->setRelation('bannedFairs', collect([new Fair]));
		$user->setRelation('helpingFairs', collect([new Fair]));
		$user->setRelation('attendingFairEvents', collect([new FairEvent]));
		$user->setRelation('comments', collect([new Comment]));

		return $user;
	}

	/**
	 * Gets user by username
	 *
	 * @param $username
	 * @return User
	 */
	public function getByUsername($username)
	{
		return $this->createUser();
	}

	/**
	 * Gets user by email
	 *
	 * @param $email
	 * @return User
	 */
	public function getByEmail($email)
	{
		return $this->createUser();
	}
}