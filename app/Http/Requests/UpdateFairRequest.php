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
			'image' 	=> 'mimes:jpg,jpeg,png',
			'latitude' 	=> 'numeric',
			'longitude' => 'numeric'
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
