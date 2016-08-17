<?php
namespace ExpoHub\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;

abstract class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
	{
		$errorArray = [];
		foreach($validator->getMessageBag()->toArray() as $key => $error) {
			array_push($errorArray, [
				'title' 	=> $key,
				'message' 	=> $error[0],
				'status' 	=> '422'
			]);
		}

		throw new HttpResponseException(new Response(
			['errors' => $errorArray], 422,
			['Content-Type' => 'application/vnd.api+json']
		));
	}

	/**
	 * Handle a failed authorization attempt.
	 *
	 * @return mixed
	 */
	protected function failedAuthorization()
	{
		throw new HttpResponseException(new Response([
			'errors' => [[
				'title'		=> 'forbidden',
				'message'	=> 'You do not have permission to execute this request',
				'status'	=> '403'
			]]
		], 403, ['Content-Type' => 'application/vnd.api+json']));
	}
}
