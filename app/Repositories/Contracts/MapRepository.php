<?php


namespace ExpoHub\Repositories\Contracts;


use Illuminate\Database\Eloquent\Collection;

interface MapRepository extends Repository
{
	/**
	 * Returns all maps registered on the specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);
}