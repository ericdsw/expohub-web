<?php
namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ExpoHub\Stand
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property integer $fair_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ExpoHub\Fair $fair
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Stand whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Stand whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Stand whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Stand whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Stand whereFairId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Stand whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Stand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stand extends Model
{
	protected $fillable = ['name', 'description', 'image', 'fair_id'];

	/**
	 * Returns formatted image url depending on storage
	 *
	 * @return string
	 */
	public function imageUrl()
	{
		if (env('FILESYSTEM') == 'local') {
			return asset($this->image);
		} else if (env('FILESYSTEM') == 'none') {
			return $this->image;
		} else {
			return 'https://s3.amazonaws.com/expo-hub/' . $this->image;
		}
	}

	/**
	 * Fair where it was registered'
	 *
	 * @return BelongsTo
	 */
	public function fair()
	{
		return $this->belongsTo(Fair::class);
	}
}
