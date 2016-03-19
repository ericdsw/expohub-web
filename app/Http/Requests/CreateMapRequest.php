<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\MapAccessController;
use ExpoHub\Http\Requests\Request;

class CreateMapRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param MapAccessController $accessController
	 * @return bool
	 */
    public function authorize(MapAccessController $accessController)
    {
        return $accessController->canCreateMapForFair(
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
			'image' => 'required|mimes:jpg,jpeg,png',
			'fair_id' => 'required|numeric'
        ];
    }

	/**
	 * @return bool
	 */
	public function wantsJson()
	{
		return true;
	}
}
