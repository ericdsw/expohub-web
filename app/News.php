<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * ExpoHub\News
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $image
 * @property integer $fair_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ExpoHub\Fair $fair
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Comment[] $comments
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\News whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\News whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\News whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\News whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\News whereFairId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\News whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
