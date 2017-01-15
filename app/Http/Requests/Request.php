<?php
namespace ExpoHub\Http\Requests;

use ExpoHub\Helpers\Generators\Contracts\JsonErrorGenerator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;
use ExpoHub\JsonError;

abstract class Request extends FormRequest
{
	/** @var JsonErrorGenerator */
	private $jsonErrorGenerator;

	/**
	 * Constructor
	 * @param JsonErrorGenerator $jsonErrorGenerator
	 */
	public function __construct(JsonErrorGenerator $jsonErrorGenerator) 
	{
		$this->jsonErrorGenerator = $jsonErrorGenerator;
	}

	/**
	 * Overrides parent's failedValidation method
	 * throws exception adjusting to JSON Api's standard
	 *
	 * @param  Validator $validator
	 */
    protected function failedValidation(Validator $validator)
	{
		$this->jsonErrorGenerator->setStatus(422);
		foreach($validator->getMessageBag()->toArray() as $key => $error) {
			$this->jsonErrorGenerator->appendError(
				new JsonError($key, $error[0], "422", "")
			);
		}
		throw new HttpResponseException($this->jsonErrorGenerator->generateErrorResponse());
	}

	/**
	 * Overrides parent's failedAuthorization method
	 * Handle a failed authorization attempt and throws a JSON Api compatible exception
	 */
	protected function failedAuthorization()
	{
		throw new HttpResponseException(
			$this->jsonErrorGenerator->setStatus(403)
				->appendError(
					new JsonError("forbidden", "You do not have permission to execute this request", "403", "")
				)->generateErrorResponse()
		);
	}
}
