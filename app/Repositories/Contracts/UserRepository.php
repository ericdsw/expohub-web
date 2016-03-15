<?php

namespace ExpoHub\Repositories\Contracts;

use ExpoHub\User;

interface UserRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return User
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return User
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return User
	 */
	public function update($id, array $parameters);

	/**
	 * Gets user by username
	 *
	 * @param $username
	 * @return User
	 */
	public function getByUsername($username);

	/**
	 * Gets user by email
	 *
	 * @param $email
	 * @return User
	 */
	public function getByEmail($email);
}