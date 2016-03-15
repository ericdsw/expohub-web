<?php

use Carbon\Carbon;
use ExpoHub\Category;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\Map;
use ExpoHub\News;
use ExpoHub\Repositories\Contracts\FairRepository;
use ExpoHub\Sponsor;
use ExpoHub\Stand;
use ExpoHub\User;

class StubFairRepository implements FairRepository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \ExpoHub\Fair
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createFair();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \ExpoHub\Fair
	 */
	public function create(array $parameters)
	{
		return $this->createFair();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \ExpoHub\Fair
	 */
	public function update($id, array $parameters)
	{
		return $this->createFair();
	}

	/**
	 * Returns fairs created by the user
	 *
	 * @param $userId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getByUser($userId)
	{
		return collect([$this->createFair()]);
	}

	/**
	 * Returns fairs the user can manage without owning
	 *
	 * @param $userId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getHelpingFairsByUser($userId)
	{
		return collect([$this->createFair()]);
	}

	/**
	 * Returns fairs the user was banned
	 *
	 * @param $userId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getBannedFairsByUser($userId)
	{
		return collect([$this->createFair()]);
	}

	/**
	 * Returns current active fairs
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getActiveFairs()
	{
		return collect([$this->createFair()]);
	}

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createFair()]);
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
	 * @return Fair
	 */
	private function createFair()
	{
		$fair = new Fair;

		// Overwrite date format
		$fair->setDateFormat('Y');

		// Parameters
		$fair->id = 1;
		$fair->name = 'name';
		$fair->image = 'image';
		$fair->description = 'description';
		$fair->website = 'website';
		$fair->starting_date = Carbon::now();
		$fair->ending_date = Carbon::now();
		$fair->address = 'address';
		$fair->latitude = 19.9;
		$fair->longitude = 20.0;

		// Relationships
		$fair->setRelation('user', new User);
		$fair->setRelation('bannedUsers', collect([new User]));
		$fair->setRelation('helperUsers', collect(new User));
		$fair->setRelation('sponsors', collect([new Sponsor]));
		$fair->setRelation('maps', collect([new Map]));
		$fair->setRelation('categories', collect([new Category]));
		$fair->setRelation('fairEvents', collect([new FairEvent]));
		$fair->setRelation('news', collect([new News]));
		$fair->setRelation('stands', collect([new Stand]));

		return $fair;
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
}