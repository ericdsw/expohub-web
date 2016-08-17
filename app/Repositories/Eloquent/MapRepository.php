<?php
namespace ExpoHub\Repositories\Eloquent;

use ExpoHub\Map;
use ExpoHub\Repositories\Contracts\MapRepository as MapRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class MapRepository extends Repository implements MapRepositoryContract
{
	/**
	 * MapRepository constructor.
	 * @param Map $model
	 */
	public function __construct(Map $model)
	{
		parent::__construct($model);
	}

	/**
	 * Returns all maps registered on the specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return $this->prepareQuery()->where('fair_id', $fairId)->get();
	}
}
