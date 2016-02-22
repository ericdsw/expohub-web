<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * ExpoHub\Category
 *
 * @property integer $id
 * @property string $name
 * @property integer $fair_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \ExpoHub\Fair $fair
 * @property \Illuminate\Database\Eloquent\Collection|\ExpoHub\FairEvent[] $fairEvents
 */
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
