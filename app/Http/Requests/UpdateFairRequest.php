<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\FairAccessController;
use ExpoHub\Http\Requests\Request;

class UpdateFairRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param FairAccessController $accessController
	 * @return bool
	 */
    public function authorize(FairAccessController $accessController)
    {
        return $accessController->canUpdateFair(
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
			'image' => 'mimes:jpg,jpeg,png',
			'description' => 'required',
			'website' => 'required',
			'starting_date' => 'required',
			'ending_date' => 'required',
			'address' => 'required',
			'latitude' => 'required|numeric',
			'longitude' => 'required|numeric'
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
