<?php
namespace ExpoHub\Transformers;

use ExpoHub\Sponsor;
use League\Fractal\Resource\Item;

class SponsorTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fair', 'sponsorRank'];

	/**
	 * Converts Sponsor to json
	 *
	 * @param Sponsor $sponsor
	 * @return array
	 */
	public function transform(Sponsor $sponsor)
	{
		return [
			'id' 		=> (int) $sponsor->id,
			'name' 		=> $sponsor->name,
			'logo' 		=> $sponsor->imageUrl(),
			'slogan' 	=> $sponsor->slogan,
			'website' 	=> $sponsor->website
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "sponsors";
	}

	/**
	 * Includes related Fair
	 *
	 * @param Sponsor $sponsor
	 * @return Item
	 */
	public function includeFair(Sponsor $sponsor)
	{
		$fair = $sponsor->fair;
		$fairTransformer = app()->make(FairTransformer::class);
		return $this->item($fair, $fairTransformer, $fairTransformer->getType());
	}

	/**
	 * Includes related SponsorRank
	 *
	 * @param Sponsor $sponsor
	 * @return Item
	 */
	public function includeSponsorRank(Sponsor $sponsor)
	{
		$sponsorRank = $sponsor->sponsorRank;
		$sponsorRankTransformer = app()->make(SponsorRankTransformer::class);
		return $this->item($sponsorRank, $sponsorRankTransformer, $sponsorRankTransformer->getType());
	}
}
