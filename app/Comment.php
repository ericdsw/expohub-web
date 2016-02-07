<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ExpoHub\Comment
 *
 * @property integer $id
 * @property string $text
 * @property integer $news_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ExpoHub\News $ownerNews
 * @property-read \ExpoHub\User $user
 */
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
