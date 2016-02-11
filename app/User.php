<?php

namespace ExpoHub;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * ExpoHub\User
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Fair[] $fairs
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Fair[] $bannedFairs
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Fair[] $helpingFairs
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\FairEvent[] $attendingFairEvents
 * @property-read \Illuminate\Database\Eloquent\Collection|\ExpoHub\Comment[] $comments
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';
    protected $fillable = ['name', 'username', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

	/**
	 * The fairs this user has created
	 *
	 * @return HasMany
	 */
	public function fairs()
	{
		return $this->hasMany(Fair::class);
	}

	/**
	 * These are all categories user has registered under his/her fairs
	 *
	 * @return HasManyThrough
	 */
	public function categories()
	{
		return $this->hasManyThrough(Category::class, Fair::class);
	}

	/**
	 * The fairs this user was banned from
	 *
	 * @return BelongsToMany
	 */
	public function bannedFairs()
	{
		return $this->belongsToMany(Fair::class, "banned_users");
	}

	/**
	 * The fairs this user can help manage
	 *
	 * @return BelongsToMany
	 */
	public function helpingFairs()
	{
		return $this->belongsToMany(Fair::class, "fair_helpers");
	}

	/**
	 * The fair events this user is attending
	 *
	 * @return BelongsToMany
	 */
	public function attendingFairEvents()
	{
		return $this->belongsToMany(FairEvent::class, "attendance")
			->withPivot("score")->withTimestamps();
	}

	/**
	 * The comments this user has generated
	 *
	 * @return HasMany
	 */
	public function comments()
	{
		return $this->hasMany(Comment::class);
	}
}
