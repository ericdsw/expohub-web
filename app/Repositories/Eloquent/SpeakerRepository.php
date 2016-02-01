<?php


namespace ExpoHub\Repositories\Eloquent;


use ExpoHub\Repositories\Contracts\SpeakerRepository as SpeakerRepositoryContract;
use ExpoHub\Speaker;
use Illuminate\Database\Eloquent\Collection;

class SpeakerRepository extends Repository implements SpeakerRepositoryContract
{
	/**
	 * SpeakerRepository constructor.
	 * @param Speaker $model
	 */
	public function __construct(Speaker $model)
	{
		parent::__construct($model);
	}

	/**
	 * Returns speaker for specified fair event
	 *
	 * @param $fairEventId
	 * @return Collection
	 */
	public function getByFairEvents($fairEventId)
	{
		return $this->model->where('fair_event_id', $fairEventId)->get();
	}
}