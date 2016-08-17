<?php
namespace ExpoHub\Specifications;

use ExpoHub\Repositories\Contracts\UserRepository;

class UserSpecification
{
	/** @var UserRepository */
	private $userRepository;

	/**
	 * UserSpecification constructor
	 *
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param $email
	 * @return bool
	 */
	public function isEmailAvailable($email)
	{
		return ($this->userRepository->getByEmail($email) == null);
	}

	/**
	 * @param $username
	 * @return bool
	 */
	public function isUsernameAvailable($username)
	{
		return ($this->userRepository->getByUsername($username) == null);
	}
}
