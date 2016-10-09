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
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Comment whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Comment whereNewsId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
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
		return $this->belongsTo(News::class, 'news_id');
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
