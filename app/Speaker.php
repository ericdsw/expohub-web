<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ExpoHub\Speaker
 *
 * @property integer $id
 * @property string $name
 * @property string $picture
 * @property string $description
 * @property integer $fair_event_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ExpoHub\FairEvent $fairEvent
 */
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
