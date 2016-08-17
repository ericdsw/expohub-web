<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
