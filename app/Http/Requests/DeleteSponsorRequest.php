<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\SponsorAccessController;
use ExpoHub\Http\Requests\Request;

class DeleteSponsorRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param SponsorAccessController $accessController
	 * @return bool
	 */
    public function authorize(SponsorAccessController $accessController)
    {
        return $accessController->canDeleteSponsorRank(
			$this->route()->parameter('id')
		);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
