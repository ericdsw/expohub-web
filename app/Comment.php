<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ["text", "news_id", "user_id"];

    /**
	 * The news that this comment was posted on
	 *
     * @return BelongsTo
     */
	public function ownerNews()
	{
		return $this->belongsTo(News::class);
	}

	/**
	 * The user that generated the comment
	 *
	 * @return BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
