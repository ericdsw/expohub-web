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
 * @property-read \ExpoHub\Fair $fair
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\FairEvent[] $fairEvents
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Category whereFairId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Category whereUpdatedAt($value)
 * @mixin \Eloquent
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
