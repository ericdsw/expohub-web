<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\StandAccessController;
use ExpoHub\Http\Requests\Request;

class CreateStandRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param StandAccessController $accessController
	 * @return bool
	 */
    public function authorize(StandAccessController $accessController)
    {
        return $accessController->canCreateStandForFair(
			$this->get('fair_id')
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
			'image' => 'required|mimes:jpg,jpeg,png',
			'fair_id' => 'required|numeric'
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
