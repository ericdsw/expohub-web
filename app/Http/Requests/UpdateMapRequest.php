<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\MapAccessController;
use ExpoHub\Http\Requests\Request;

class UpdateMapRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param MapAccessController $accessController
	 * @return bool
	 */
    public function authorize(MapAccessController $accessController)
    {
        return $accessController->canUpdateMap(
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
			'image' => 'mimes:jpg,jpeg,png'
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
