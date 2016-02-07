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
 */
class Stand extends Model
{
	protected $fillable = ['name', 'description', 'image', 'fair_id'];

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