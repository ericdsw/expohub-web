<?php

namespace ExpoHub\Transformers;


use ExpoHub\SponsorRank;
use League\Fractal\Resource\Collection;

class SponsorRankTransformer extends BaseTransformer
{
	protected $availableIncludes = ['sponsors'];

	/**
	 * Converts SponsorRank to json
	 *
	 * @param SponsorRank $sponsorRank
	 * @return array
	 */
	public function transform(SponsorRank $sponsorRank)
	{
		return [
			'id' => (int) $sponsorRank->id,
			'name' => $sponsorRank->name
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "sponsor-rank";
	}

	/**
	 * Include related Sponsors
	 *
	 * @param SponsorRank $sponsorRank
	 * @return Collection
	 */
	public function includeSponsors(SponsorRank $sponsorRank)
	{
		$sponsors = $sponsorRank->sponsors;
		$sponsorTransformer = app()->make(SponsorTransformer::class);
		return $this->collection($sponsors, $sponsorTransformer, $sponsorTransformer->getType());
	}
}