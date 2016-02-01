<?php


namespace ExpoHub\Repositories\Contracts;


use Illuminate\Database\Eloquent\Collection;

interface SpeakerRepository extends Repository
{
	/**
	 * Returns speaker for specified fair event
	 *
	 * @param $fairEventId
	 * @return Collection
	 */
	public function getByFairEvents($fairEventId);
}