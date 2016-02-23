<?php

use Carbon\Carbon;
use ExpoHub\Fair;
use ExpoHub\Repositories\Contracts\FairRepository;

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

		// HACKZ: date format is not set by default, to we set it to avoid consulting the database
		$fair->setDateFormat('Y');

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

		return $fair;
	}
}