<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ExpoHub\Map
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property integer $fair_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ExpoHub\Fair $fair
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Map whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Map whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Map whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Map whereFairId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Map whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Map whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Map extends Model
{
    protected $fillable = ["name", "image", "fair_id"];

	/**
	 * Returns formatted image url depending on storage
	 *
	 * @return string
	 */
	public function imageUrl()
	{
		if(getenv('FILESYSTEM') == 'local') {
			return asset($this->image);
		} else {
			return 'https://s3.amazonaws.com/expo-hub/' . $this->image;
		}
	}

	/**
	 * Fair where this map was registered
	 *
	 * @return BelongsTo
	 */
	public function fair()
	{
		return $this->belongsTo(Fair::class);
	}
}
