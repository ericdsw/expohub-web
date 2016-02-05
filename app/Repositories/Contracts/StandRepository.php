<?php

namespace ExpoHub\Repositories\Contracts;


interface StandRepository extends Repository
{
	/**
	 * Returns stands on specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);
}