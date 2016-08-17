<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\NewsAccessController;
use ExpoHub\Http\Requests\Request;

class DeleteNewsRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param NewsAccessController $accessController
	 * @return bool
	 */
    public function authorize(NewsAccessController $accessController)
    {
        return $accessController->canDeleteNews(
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
