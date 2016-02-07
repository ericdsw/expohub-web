<?php


namespace ExpoHub\Transformers;


use ExpoHub\Sponsor;

class SponsorTransformer extends BaseTransformer
{
	/**
	 * Converts Sponsor to json
	 *
	 * @param Sponsor $sponsor
	 * @return array
	 */
	public function transform(Sponsor $sponsor)
	{
		return [
			'id' => (int) $sponsor->id,
			'name' => $sponsor->name,
			'logo' => $sponsor->logo,
			'slogan' => $sponsor->slogan,
			'website' => $sponsor->website
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "sponsor";
	}
}