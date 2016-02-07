<?php

namespace ExpoHub\Transformers;


use ExpoHub\SponsorRank;

class SponsorRankTransformer extends BaseTransformer
{
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
}