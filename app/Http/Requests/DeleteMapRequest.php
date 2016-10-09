<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\MapAccessController;
use ExpoHub\Http\Requests\Request;

class DeleteMapRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param MapAccessController $accessController
	 * @return bool
	 */
    public function authorize(MapAccessController $accessController)
    {
        return $accessController->canDeleteMap(
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
}
