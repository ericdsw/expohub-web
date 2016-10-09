<?php
namespace ExpoHub\Repositories\Eloquent;

use ExpoHub\Repositories\Contracts\SponsorRankRepository as SponsorRankRepositoryContract;
use ExpoHub\SponsorRank;

class SponsorRankRepository extends Repository implements SponsorRankRepositoryContract
{
	public function __construct(SponsorRank $model)
	{
		parent::__construct($model);
	}
}
