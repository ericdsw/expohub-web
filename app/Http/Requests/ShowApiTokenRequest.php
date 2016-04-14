<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\ApiTokenAccessController;
use ExpoHub\Constants\UserType;
use ExpoHub\Http\Requests\Request;

class ShowApiTokenRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param ApiTokenAccessController $accessController
	 * @return bool
	 */
    public function authorize(ApiTokenAccessController $accessController)
    {
        return $accessController->canShowApiToken();
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
