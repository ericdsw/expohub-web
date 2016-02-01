<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = ["name", "fair_id"];

    /**
	 * The fair to which this category was registered
	 *
     * @return BelongsTo
     */
	public function fair()
	{
		return $this->belongsTo(Fair::class);
	}

	/**
	 * The events registered under this category
	 *
	 * @return BelongsToMany
	 */
	public function fairEvents()
	{
		return $this->belongsToMany(FairEvent::class, "event_category");
	}
}
