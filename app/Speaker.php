<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Speaker extends Model
{
    protected $fillable = ["name", "picture", "description", "fair_event_id"];

	/**
	 * The fair event this speaker is participating
	 *
	 * @return BelongsTo
	 */
	public function fairEvent()
	{
		return $this->belongsTo(FairEvent::class);
	}
}
