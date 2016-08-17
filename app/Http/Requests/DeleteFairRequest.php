<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\FairAccessController;
use ExpoHub\Http\Requests\Request;

class DeleteFairRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param FairAccessController $accessController
	 * @return bool
	 */
    public function authorize(FairAccessController $accessController)
    {
        return $accessController->canDeleteFair(
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
