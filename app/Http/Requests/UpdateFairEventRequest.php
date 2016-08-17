<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\FairEventAccessController;
use ExpoHub\Http\Requests\Request;

class UpdateFairEventRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param FairEventAccessController $accessController
	 * @return bool
	 */
    public function authorize(FairEventAccessController $accessController)
    {
        return $accessController->canUpdateFairEvent(
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
			'image' => 'mimes:jpg,jpeg,png',
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
