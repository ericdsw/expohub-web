<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * ExpoHub\SponsorRank
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Sponsor[] $sponsors
 */
class SponsorRank extends Model
{
    protected $fillable = ["name"];

	/**
	 * The sponsors associated with this sponsor rank
	 *
	 * @return HasMany
	 */
	public function sponsors()
	{
		return $this->hasMany(Sponsor::class);
	}
}
