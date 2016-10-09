<?php
namespace ExpoHub\Repositories\Eloquent;

use ExpoHub\Repositories\Contracts\SponsorRepository as SponsorRepositoryContract;
use ExpoHub\Sponsor;
use Illuminate\Database\Eloquent\Collection;

class SponsorRepository extends Repository implements SponsorRepositoryContract
{
	/**
	 * SponsorRepository constructor.
	 * @param Sponsor $model
	 */
	public function __construct(Sponsor $model)
	{
		parent::__construct($model);
	}

	/**
	 * Returns Sponsors on specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return $this->prepareQuery()->where('fair_id', $fairId)->get();
	}

	/**
	 * Returns Sponsors on specified sponsor rank
	 *
	 * @param $sponsorRankId
	 * @return Collection
	 */
	public function getBySponsorRank($sponsorRankId)
	{
		return $this->prepareQuery()->where('sponsor_rank_id', $sponsorRankId)->get();
	}
}
