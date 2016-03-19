<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\EventTypeAccessController;
use ExpoHub\Http\Requests\Request;

class CreateEventTypeRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param EventTypeAccessController $eventTypeAccessController
	 * @return bool
	 */
    public function authorize(EventTypeAccessController $eventTypeAccessController)
    {
        return $eventTypeAccessController->canCreateEventType();
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

	/**
	 * @return bool
	 */
	public function wantsJson()
	{
		return true;
	}
}
