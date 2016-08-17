<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\EventTypeAccessController;
use ExpoHub\Http\Requests\Request;

class DeleteEventTypeRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param EventTypeAccessController $accessController
	 * @return bool
	 */
    public function authorize(EventTypeAccessController $accessController)
    {
        return $accessController->canDeleteEventType();
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
