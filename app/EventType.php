<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * ExpoHub\EventType
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\FairEvent[] $events
 */
class EventType extends Model
{
    protected $fillable = ["name"];

    /**
	 * The events registered under this event type
	 *
     * @return return HasMany
     */
	public function events()
	{
		return $this->hasMany(FairEvent::class);
	}
}
