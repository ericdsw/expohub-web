<?php

namespace ExpoHub\Helpers\Generators;

use ExpoHub\JsonError;
use Illuminate\Http\Response;
use ExpoHub\Helpers\Generators\Contracts\JsonErrorGenerator as JsonErrorGeneratorContract;

class JsonErrorGenerator implements JsonErrorGeneratorContract 
{
	private $jsonErrors = [];
	private $status;

	/**
	 * Sets the current request status
	 * @param int $status 			The request return status
	 * @return JsonErrorGenerator   The JsonErrorGenerator instance
	 */
	public function setStatus($status) 
	{
		$this->status = $status;
		return $this;
	}

	/**
	 * Appends a new error instance to the generator
	 * @param  JsonError $error 	The error to append
	 * @return JsonErrorGenerator   The JsonErrorGenerator instance
	 */
	public function appendError(JsonError $error)
	{
		$this->jsonErrors[] = $error;
		return $this;
	}

	/**
	 * Generates a response object containing the specified errors
	 * @return Response
	 */
	public function generateErrorResponse()
	{
		$responseBody 	= $this->generateErrorJson();
		$response 		= new Response($responseBody, $this->status, []);

		$response->header("Content-Type", "application/vnd.api+json");
		return $response;
	}

	/**
	 * Generates an array containing the specified errors
	 * @return array
	 */
	public function generateErrorJson()
	{
		$responseBody = [];
		foreach($this->jsonErrors as $jsonError) {
			$responseBody[] = $jsonError;
		}

		return [
			'errors' => $responseBody
		];	
	}
}
