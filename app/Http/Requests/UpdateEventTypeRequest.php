<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\EventTypeAccessController;
use ExpoHub\Http\Requests\Request;

class UpdateEventTypeRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param EventTypeAccessController $accessController
	 * @return bool
	 */
    public function authorize(EventTypeAccessController $accessController)
    {
        return $accessController->canUpdateEventType();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
