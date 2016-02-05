<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fair extends Model
{
    protected $fillable = ["name", "image", "description", "website", "starting_date", "ending_date", "address", "latitude", "longitude", "user_id"];
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
