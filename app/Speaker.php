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
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Speaker whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Speaker whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Speaker wherePicture($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Speaker whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Speaker whereFairEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Speaker whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Speaker whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Speaker extends Model
{
    protected $fillable = ["name", "picture", "description", "fair_event_id"];

	/**
	 * Returns formatted image url depending on storage
	 *
	 * @return string
	 */
	public function imageUrl()
	{
		if (getenv('FILESYSTEM') == 'local') {
			return asset($this->picture);
		} else {
			return 'https://s3.amazonaws.com/expo-hub/' . $this->picture;
		}
	}

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
