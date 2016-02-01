<?php


namespace ExpoHub\Repositories\Contracts;


use Illuminate\Database\Eloquent\Collection;

interface SponsorRepository extends Repository
{
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