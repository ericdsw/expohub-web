<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\Http\Requests\Request;

class CreateFairEventRequest extends Request
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
            'title' => 'required',
			'image' => 'required|mimes:jpg,jpeg,png',
			'description' => 'required',
			'date' => 'required',
			'location' => 'required',
			'fair_id' => 'required|numeric',
			'event_type_id' => 'required|numeric'
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
