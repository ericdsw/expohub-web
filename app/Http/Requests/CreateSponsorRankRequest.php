<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\SponsorRankAccessController;
use ExpoHub\Http\Requests\Request;

class CreateSponsorRankRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param SponsorRankAccessController $accessController
	 * @return bool
	 */
    public function authorize(SponsorRankAccessController $accessController)
    {
        return $accessController->canCreateSponsorRank();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
