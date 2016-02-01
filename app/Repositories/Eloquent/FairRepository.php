<?php

namespace ExpoHub\Repositories\Eloquent;


use Carbon\Carbon;
use ExpoHub\Fair;
use ExpoHub\Repositories\Contracts\FairRepository as FairRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class FairRepository extends Repository implements FairRepositoryContract
{
	/**
	 * FairRepository constructor.
	 * @param Fair $model
	 */
	public function __construct(Fair $model)
	{
		parent::__construct($model);
	}

	/**
	 * Returns fairs created by the user
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByUser($userId)
	{
		return $this->model->where('user_id', $userId)->get();
	}

	/**
	 * Returns fairs the user can manage without owning
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getHelpingFairsByUser($userId)
	{
		$bannedFairIds = $this->model->whereHas('bannedUsers', function($query) use ($userId) {
			$query->where('id', $userId);
		})->get()->lists('id');

		return $this->model->whereHas('helperUsers', function($query) use ($userId) {
			$query->where('id', $userId);
		})->where('user_id', '!=', $userId)->whereNotIn('id', $bannedFairIds)->get();
	}

	/**
	 * Returns fairs the user was banned
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getBannedFairsByUser($userId)
	{
		return $this->model->whereHas('bannedUsers', function($query) use ($userId) {
			$query->where('id', $userId);
		})->get();
	}

	/**
	 * Returns current active fairs
	 *
	 * @return Collection
	 */
	public function getActiveFairs()
	{
		return $this->model->where('starting_date', '<=', Carbon::now())
			->where('ending_date', '>=', Carbon::now())
			->get();
	}
}