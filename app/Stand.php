<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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