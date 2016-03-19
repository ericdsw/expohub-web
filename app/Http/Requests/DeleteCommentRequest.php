<?php

namespace ExpoHub\Http\Requests;

use ExpoHub\AccessControllers\CommentAccessController;
use ExpoHub\Http\Requests\Request;
use ExpoHub\Specifications\CommentSpecification;

class DeleteCommentRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param CommentAccessController $accessController
	 * @return bool
	 */
    public function authorize(CommentAccessController $accessController)
    {
        return $accessController->canDeleteComment(
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
            //
        ];
    }

	public function wantsJson()
	{
		return true;
	}
}
