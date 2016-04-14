<?php

namespace ExpoHub\Transformers;


use ExpoHub\User;
use League\Fractal\Resource\Collection;

class UserTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fairs', 'bannedFairs', 'helpingFairs', 'attendingFairEvents', 'comments'];

	/**
	 * Converts User to json
	 *
	 * @param User $user
	 * @return array
	 */
	public function transform(User $user)
	{
		return [
			'id' 		=> (int) $user->id,
			'name' 		=> $user->name,
			'username' 	=> $user->username,
			'email' 	=> $user->email
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'users';
	}

	/**
	 * Include related Fairs
	 *
	 * @param User $user
	 * @return Collection
	 */
	public function includeFairs(User $user)
	{
		$fairs = $user->fairs;
		$fairTransformer = app()->make(FairTransformer::class);
		return $this->collection($fairs, $fairTransformer, $fairTransformer->getType());
	}

	/**
	 * Include related Fairs where user was banned
	 *
	 * @param User $user
	 * @return Collection
	 */
	public function includeBannedFairs(User $user)
	{
		$fairs = $user->bannedFairs;
		$fairTransformer = app()->make(FairTransformer::class);
		return $this->collection($fairs, $fairTransformer, $fairTransformer->getType());
	}

	/**
	 * Include related Fairs where user is helping
	 *
	 * @param User $user
	 * @return Collection
	 */
	public function includeHelpingFairs(User $user)
	{
		$fairs = $user->helpingFairs;
		$fairTransformer = app()->make(FairTransformer::class);
		return $this->collection($fairs, $fairTransformer, $fairTransformer->getType());
	}

	/**
	 * Include related Fairs where user is attending
	 *
	 * @param User $user
	 * @return Collection
	 */
	public function includeAttendingFairEvents(User $user)
	{
		$attendingFairEvents = $user->attendingFairEvents;
		$fairEventTransformer = app()->make(FairEventTransformer::class);
		return $this->collection($attendingFairEvents, $fairEventTransformer, $fairEventTransformer->getType());
	}

	/**
	 * Include related Comments
	 *
	 * @param User $user
	 * @return Collection
	 */
	public function includeComments(User $user)
	{
		$comments = $user->comments;
		$commentTransformer = app()->make(CommentTransformer::class);
		return $this->collection($comments, $commentTransformer, $commentTransformer->getType());
	}
}