<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\Http\Requests\Request;

class UpdateFairRequest extends Request
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
			'description' => 'required',
			'website' => 'required',
			'starting_date' => 'required',
			'ending_date' => 'required',
			'address' => 'required',
			'latitude' => 'required|numeric',
			'longitude' => 'required|numeric'
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
