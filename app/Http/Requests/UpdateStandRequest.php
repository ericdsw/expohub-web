<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\StandAccessController;
use ExpoHub\Http\Requests\Request;

class UpdateStandRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param StandAccessController $accessController
	 * @return bool
	 */
    public function authorize(StandAccessController $accessController)
    {
        return $accessController->canUpdateStand(
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
			'name' => 'required',
			'description' => 'required',
			'image' => 'mimes:jpg,jpeg,png',
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
