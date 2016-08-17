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
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\EventType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\EventType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\EventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\EventType whereUpdatedAt($value)
 * @mixin \Eloquent
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
