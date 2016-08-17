<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\CategoryAccessController;
use ExpoHub\Http\Requests\Request;

class DeleteCategoryRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param CategoryAccessController $accessController
	 * @return bool
	 */
    public function authorize(CategoryAccessController $accessController)
    {
        return $accessController->canDeleteCategory(
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
