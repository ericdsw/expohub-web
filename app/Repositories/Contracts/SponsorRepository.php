<?php
namespace ExpoHub\Repositories\Contracts;

use ExpoHub\Sponsor;
use Illuminate\Database\Eloquent\Collection;

interface SponsorRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Sponsor
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return Sponsor
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return Sponsor
	 */
	public function update($id, array $parameters);

	/**
	 * Returns Sponsors on specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);

	/**
	 * Returns Sponsors on specified sponsor rank
	 *
	 * @param $sponsorRankId
	 * @return Collection
	 */
	public function getBySponsorRank($sponsorRankId);
}
