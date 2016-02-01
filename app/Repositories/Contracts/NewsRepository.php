<?php


namespace ExpoHub\Repositories\Contracts;


use Illuminate\Database\Eloquent\Collection;

interface NewsRepository extends Repository
{
	/**
	 * Returns all news posted to the specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);
}