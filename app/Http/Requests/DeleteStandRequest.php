<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\StandAccessController;
use ExpoHub\Http\Requests\Request;

class DeleteStandRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param StandAccessController $accessController
	 * @return bool
	 */
    public function authorize(StandAccessController $accessController)
    {
        return $accessController->canDeleteStand(
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
