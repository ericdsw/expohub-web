<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\SpeakerAccessController;
use ExpoHub\Http\Requests\Request;

class UpdateSpeakerRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param SpeakerAccessController $accessController
	 * @return bool
	 */
    public function authorize(SpeakerAccessController $accessController)
    {
        return $accessController->canUpdateSpeaker(
			$this->route()->parameter('id')
		);
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
			'description' => 'required'
		];
    }

	public function wantsJson()
	{
		return true;
	}
}
