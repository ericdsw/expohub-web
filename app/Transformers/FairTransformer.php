<?php
namespace ExpoHub\Transformers;

use ExpoHub\Fair;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class FairTransformer extends BaseTransformer
{
	protected $availableIncludes = ['user',
									'bannedUsers', 'helperUsers', 'sponsors', 'maps', 'categories',
											'fairEvents', 'news', 'stands'];

	/**
	 * Converts Fair to valid json
	 *
	 * @param Fair $fair
	 * @return array
	 */
	public function transform(Fair $fair)
	{
		return [
			'id' 			=> (int) $fair->id,
			'name'	 		=> $fair->name,
			'image' 		=> $fair->imageUrl(),
			'description' 	=> $fair->description,
			'website' 		=> $fair->website,
			'starting_date' => ($fair->starting_date != null) ? $fair->starting_date->toDateTimeString() : "",
			'ending_date' 	=> ($fair->ending_date != null) ? $fair->ending_date->toDateTimeString() : "",
			'address' 		=> $fair->address,
			'latitude' 		=> $fair->latitude,
			'longitude' 	=> $fair->longitude,
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "fairs";
	}

	/**
	 * Includes related User
	 *
	 * @param Fair $fair
	 * @return Item
	 */
	public function includeUser(Fair $fair)
	{
		$user = $fair->user;
		$userTransformer = app()->make(UserTransformer::class);
		return $this->item($user, $userTransformer, $userTransformer->getType());
	}

	/**
	 * Include related Fairs
	 *
	 * @param Fair $fair
	 * @return Collection
	 */
	public function includeBannedUsers(Fair $fair)
	{
		$bannedUsers = $fair->bannedUsers;
		$userTransformer = app()->make(UserTransformer::class);
		return $this->collection($bannedUsers, $userTransformer, $userTransformer->getType());
	}

	/**
	 * Include related HelperUsers
	 *
	 * @param Fair $fair
	 * @return Collection
	 */
	public function includeHelperUsers(Fair $fair)
	{
		$helperUsers = $fair->helperUsers;
		$userTransformer = app()->make(UserTransformer::class);
		return $this->collection($helperUsers, $userTransformer, $userTransformer->getType());
	}

	/**
	 * Include related Sponsors
	 *
	 * @param Fair $fair
	 * @return Collection
	 */
	public function includeSponsors(Fair $fair)
	{
		$sponsors = $fair->sponsors;
		$sponsorTransformer = app()->make(SponsorTransformer::class);
		return $this->collection($sponsors, $sponsorTransformer, $sponsorTransformer->getType());
	}

	/**
	 * Include related Maps
	 *
	 * @param Fair $fair
	 * @return Collection
	 */
	public function includeMaps(Fair $fair)
	{
		$maps = $fair->maps;
		$mapTransformer = app()->make(MapTransformer::class);
		return $this->collection($maps, $mapTransformer, $mapTransformer->getType());
	}

	/**
	 * Include related Categories
	 *
	 * @param Fair $fair
	 * @return Collection
	 */
	public function includeCategories(Fair $fair)
	{
		$categories = $fair->categories;
		$categoryTransformer = app()->make(CategoryTransformer::class);
		return $this->collection($categories , $categoryTransformer, $categoryTransformer->getType());
	}

	/**
	 * Include related FairEvents
	 *
	 * @param Fair $fair
	 * @return Collection
	 */
	public function includeFairEvents(Fair $fair)
	{
		$fairEvents = $fair->fairEvents;
		$fairEventTransformer = app()->make(FairEventTransformer::class);
		return $this->collection($fairEvents, $fairEventTransformer, $fairEventTransformer->getType());
	}

	/**
	 * Include related News
	 *
	 * @param Fair $fair
	 * @return Collection
	 */
	public function includeNews(Fair $fair)
	{
		$news = $fair->news;
		$newsTransformer = app()->make(NewsTransformer::class);
		return $this->collection($news, $newsTransformer, $newsTransformer->getType());
	}

	/**
	 * Include related Stands
	 *
	 * @param Fair $fair
	 * @return Collection
	 */
	public function includeStands(Fair $fair)
	{
		$stands = $fair->stands;
		$standTransformer = app()->make(StandTransformer::class);
		return $this->collection($stands, $standTransformer, $standTransformer->getType());
	}
}
