<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\Http\Requests\Request;

class CreateStandRequest extends Request
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
			'description' => 'required',
			'image' => 'required|mimes:jpg,jpeg,png',
			'fair_id' => 'required|numeric'
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
