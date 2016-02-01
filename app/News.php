<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    protected $fillable = ["title", "content", "image", "fair_id"];

	/**
	 * Fair where this news was posted
	 *
	 * @return BelongsTo
	 */
	public function fair()
	{
		return $this->belongsTo(Fair::class);
	}

	/**
	 * The news comments
	 *
	 * @return HasMany
	 */
	public function comments()
	{
		return $this->hasMany(Comment::class);
	}
}
