<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ExpoHub\Sponsor
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 * @property string $slogan
 * @property string $website
 * @property integer $fair_id
 * @property integer $sponsor_rank_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ExpoHub\Fair $fair
 * @property-read \ExpoHub\SponsorRank $sponsorRank
 */
class Sponsor extends Model
{
    protected $fillable = ["name", "logo", "slogan", "website", "fair_id", "sponsor_rank_id"];

	/**
	 * The fair this sponsor was registered
	 *
	 * @return BelongsTo
	 */
	public function fair()
	{
		return $this->belongsTo(Fair::class);
	}

	/**
	 * The sponsor rank this sponsor was registered
	 *
	 * @return BelongsTo
	 */
	public function sponsorRank()
	{
		return $this->belongsTo(SponsorRank::class);
	}
}
