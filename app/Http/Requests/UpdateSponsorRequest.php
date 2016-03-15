<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\Http\Requests\Request;

class UpdateSponsorRequest extends Request
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
			'name' => 'required',
			'image' => 'mimes:jpg,jpeg,png',
			'slogan' => 'required',
			'website' => 'required',
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
