<?php

use ExpoHub\Fair;
use ExpoHub\Repositories\Contracts\SponsorRepository;
use ExpoHub\Sponsor;
use ExpoHub\SponsorRank;

class StubSponsorRepository implements SponsorRepository
{
	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createSponsor()]);
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
	 * @return \ExpoHub\Sponsor
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createSponsor();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \ExpoHub\Sponsor
	 */
	public function create(array $parameters)
	{
		return $this->createSponsor();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \ExpoHub\Sponsor
	 */
	public function update($id, array $parameters)
	{
		return $this->createSponsor();
	}

	/**
	 * Returns Sponsors on specified fair
	 *
	 * @param $fairId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getByFair($fairId)
	{
		return collect([$this->createSponsor()]);
	}

	/**
	 * Returns Sponsors on specified sponsor rank
	 *
	 * @param $sponsorRankId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getBySponsorRank($sponsorRankId)
	{
		return collect([$this->createSponsor()]);
	}

	/**
	 * @return Sponsor
	 */
	private function createSponsor()
	{
		$sponsor = new Sponsor;

		$sponsor->id = 1;
		$sponsor->name = "foo";
		$sponsor->logo = "foo.jpg";
		$sponsor->slogan = "bar";
		$sponsor->website = "baz";

		$sponsor->setRelation('fair', new Fair);
		$sponsor->setRelation('sponsorRank', new SponsorRank);

		return $sponsor;
	}
}