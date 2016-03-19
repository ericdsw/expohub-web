<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * ExpoHub\Fair
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $website
 * @property \Carbon\Carbon $starting_date
 * @property \Carbon\Carbon $ending_date
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \ExpoHub\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\User[] $bannedUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\User[] $helperUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Sponsor[] $sponsors
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Map[] $maps
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\FairEvent[] $fairEvents
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\News[] $news
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Stand[] $stands
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereStartingDate($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereEndingDate($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\Fair whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Fair extends Model
{
    protected $fillable = ["name", "image", "description", "website", "starting_date",
		 				   "ending_date", "address", "latitude", "longitude", "user_id"];

	protected $dates = ["starting_date", "ending_date"];

	/**
	 * the user that created the event
	 *
	 * @return BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Users restricted from generating content for the event
	 *
	 * @return BelongsToMany
	 */
	public function bannedUsers()
	{
		return $this->belongsToMany(User::class, "banned_users")
			->withTimestamps();
	}

	/**
	 * Users registered to help manage the event (besides owner)
	 *
	 * @return BelongsToMany
	 */
	public function helperUsers()
	{
		return $this->belongsToMany(User::class, "fair_helpers");
	}

	/**
	 * Registered fair sponsors
	 *
	 * @return HasMany
	 */
	public function sponsors()
	{
		return $this->hasMany(Sponsor::class);
	}

	/**
	 * Registered fair maps
	 *
	 * @return HasMany
	 */
	public function maps()
	{
		return $this->hasMany(Map::class);
	}

	/**
	 * Registered fair categories
	 *
	 * @return HasMany
	 */
	public function categories()
	{
		return $this->hasMany(Category::class);
	}

	/**
	 * Registered fair events
	 *
	 * @return HasMany
	 */
	public function fairEvents()
	{
		return $this->hasMany(FairEvent::class);
	}
	
	/**
	 * Registered fair news
	 *
	 * @return HasMany
	 */
	public function news()
	{
		return $this->hasMany(News::class);
	}

	/**
	 * Registered stands
	 *
	 * @return HasMany
	 */
	public function stands()
	{
		return $this->hasMany(Stand::class);
	}
}
