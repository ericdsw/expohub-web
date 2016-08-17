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
}
