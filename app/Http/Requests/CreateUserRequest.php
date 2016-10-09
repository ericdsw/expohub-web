<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\UserAccessController;
use ExpoHub\Http\Requests\Request;

class CreateUserRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param UserAccessController $accessController
	 * @return bool
	 */
    public function authorize(UserAccessController $accessController)
    {
        return $accessController->canCreateUser();
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
			'username' 	=> 'required',
			'email' 	=> 'required|email',
			'password' 	=> 'required'
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
