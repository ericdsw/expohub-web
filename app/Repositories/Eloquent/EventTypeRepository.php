<?php

namespace ExpoHub\Repositories\Eloquent;


use ExpoHub\EventType;
use ExpoHub\Repositories\Contracts\EventTypeRepository as EventTypeRepositoryContract;

class EventTypeRepository extends Repository implements EventTypeRepositoryContract
{
	/**
	 * EventTypeRepository constructor.
	 * @param EventType $model
	 */
	public function __construct(EventType $model)
	{
		parent::__construct($model);
	}

	/**
	 * @param int $id
	 * @param array $eagerLoading
	 * @return EventType
	 */
	public function find($id, array $eagerLoading = [])
	{
		return parent::find($id, $eagerLoading);
	}

	/**
	 * @param array $parameters
	 * @return EventType
	 */
	public function create(array $parameters)
	{
		return parent::create($parameters);
	}

	/**
	 * @param int $id
	 * @param array $parameters
	 * @return EventType
	 */
	public function update($id, array $parameters)
	{
		return parent::update($id, $parameters);
	}
}