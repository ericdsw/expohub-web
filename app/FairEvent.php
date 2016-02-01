<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FairEvent extends Model
{
	protected $table = "fair_events";
    protected $fillable = ["title", "image", "description", "date", "location", "fair_id", "event_type_id"];

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
