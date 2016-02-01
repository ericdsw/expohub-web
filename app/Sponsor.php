<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
