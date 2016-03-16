<?php

namespace ExpoHub\Repositories\Eloquent;


use ExpoHub\Category;
use ExpoHub\Repositories\Contracts\CategoryRepository as CategoryRepositoryContract;
use ExpoHub\User;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends Repository implements CategoryRepositoryContract
{
	protected $userModel;

	/**
	 * CategoryRepository constructor.
	 * @param Category $model
	 * @param User $user
	 */
	public function __construct(Category $model, User $user)
	{
		parent::__construct($model);
		$this->userModel = $user;
	}

	/**
	 * Returns categories registered in specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return $this->prepareQuery()->where('fair_id', $fairId)->get();
	}

	/**
	 * Returns categories registered for all the user's fairs
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByUser($userId)
	{
		return $this->prepareQuery($this->userModel)->findOrFail($userId)->categories;
	}
}