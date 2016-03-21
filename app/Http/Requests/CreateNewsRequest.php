<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\NewsAccessController;
use ExpoHub\Http\Requests\Request;

class CreateNewsRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param NewsAccessController $newsAccessController
	 * @return bool
	 */
    public function authorize(NewsAccessController $newsAccessController)
    {
        return $newsAccessController->canCreateNewsForFair(
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
            'title' 	=> 'required',
			'content' 	=> 'required',
			'image' 	=> 'required|mimes:jpg,jpeg,png',
			'fair_id' 	=> 'required|numeric'
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
