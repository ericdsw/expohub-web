<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
