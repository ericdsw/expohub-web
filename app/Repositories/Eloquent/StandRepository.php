<?php
namespace ExpoHub\Repositories\Eloquent;

use ExpoHub\Repositories\Contracts\Collection;
use ExpoHub\Repositories\Contracts\StandRepository as StandRepositoryContract;
use ExpoHub\Stand;

class StandRepository extends Repository implements StandRepositoryContract
{
	public function __construct(Stand $model)
	{
		parent::__construct($model);
	}

	/**
	 * Returns stands on specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return $this->prepareQuery()->where('fair_id', $fairId)->get();
	}
}
