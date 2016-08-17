<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\SponsorAccessController;
use ExpoHub\Http\Requests\Request;

class CreateSponsorRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param SponsorAccessController $accessController
	 * @return bool
	 */
    public function authorize(SponsorAccessController $accessController)
    {
        return $accessController->canCreateSponsorForFair(
			$this->get('fair_id')
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
            'name' 				=> 'required',
			'image'	 			=> 'required|mimes:jpg,jpeg,png',
			'slogan' 			=> 'required',
			'website' 			=> 'required',
			'fair_id' 			=> 'required|numeric',
			'sponsor_rank_id' 	=> 'required|numeric'
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
