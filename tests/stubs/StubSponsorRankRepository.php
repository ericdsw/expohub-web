<?php

use ExpoHub\Repositories\Contracts\SponsorRankRepository;
use ExpoHub\Sponsor;
use ExpoHub\SponsorRank;

class StubSponsorRankRepository implements SponsorRankRepository
{

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createSponsorRank()]);
	}

	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createSponsorRank();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function create(array $parameters)
	{
		return $this->createSponsorRank();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function update($id, array $parameters)
	{
		return $this->createSponsorRank();
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
	 * @return SponsorRank
	 */
	public function createSponsorRank()
	{
		$sponsorRank = new SponsorRank;
		$sponsorRank->id = 1;
		$sponsorRank->name = "foo";

		$sponsorRank->setRelation('sponsors', collect([new Sponsor]));

		return $sponsorRank;
	}
}