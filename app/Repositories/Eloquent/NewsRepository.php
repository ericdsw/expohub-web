<?php


namespace ExpoHub\Repositories\Eloquent;


use ExpoHub\News;
use ExpoHub\Repositories\Contracts\NewsRepository as NewsRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class NewsRepository extends Repository implements NewsRepositoryContract
{
	/**
	 * NewsRepository constructor.
	 * @param News $model
	 */
	public function __construct(News $model)
	{
		parent::__construct($model);
	}

	/**
	 * Returns all news posted to the specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return $this->model->where('fair_id', $fairId)->get();
	}
}