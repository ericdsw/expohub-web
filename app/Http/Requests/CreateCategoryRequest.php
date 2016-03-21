<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\CategoryAccessController;
use ExpoHub\Http\Requests\Request;

class CreateCategoryRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param CategoryAccessController $accessController
	 * @return bool
	 */
    public function authorize(CategoryAccessController $accessController)
    {
		return $accessController->canCreateCategoryForFair(
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
			'name' 		=> 'required',
			'fair_id' 	=> 'required|numeric'
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
