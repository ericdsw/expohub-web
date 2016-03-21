<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * ExpoHub\FairEvent
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property string $date
 * @property string $location
 * @property integer $fair_id
 * @property integer $event_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ExpoHub\Fair $fair
 * @property-read \ExpoHub\EventType $eventType
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Speaker[] $speakers
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\User[] $attendingUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Category[] $categories
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereFairId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereEventTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\FairEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FairEvent extends Model
{
	protected $table 	= "fair_events";
    protected $fillable = ["title", "image", "description", "date", "location", "fair_id", "event_type_id"];
	protected $dates	= ['date'];

	/**
	 * Fair the event was registered
	 *
	 * @return BelongsTo
	 */
	public function fair()
	{
		return $this->belongsTo(Fair::class);
	}

	/**
	 * Event type assigned to this fair event
	 *
	 * @return BelongsTo
	 */
	public function eventType()
	{
		return $this->belongsTo(EventType::class);
	}

	/**
	 * Speakers participating on this event
	 *
	 * @return HasMany
	 */
	public function speakers()
	{
		return $this->hasMany(Speaker::class);
	}

	/**
	 * Users attending to this event
	 *
	 * @return BelongsToMany
	 */
	public function attendingUsers()
	{
		return $this->belongsToMany(User::class, "attendance")
			->withPivot("score")->withTimestamps();
	}

	/**
	 * Categories where this event was registered
	 *
	 * @return BelongsToMany
	 */
	public function categories()
	{
		return $this->belongsToMany(Category::class, "event_category");
	}
}
