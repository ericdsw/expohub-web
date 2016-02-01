<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
