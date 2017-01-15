<?php

namespace ExpoHub\Helpers\Generators\Contracts;

use ExpoHub\JsonError;
use Illuminate\Http\Response;

interface JsonErrorGenerator 
{
	/**
	 * Sets the current request status
	 * @param int $status 			The request return status
	 * @return JsonErrorGenerator   The JsonErrorGenerator instance
	 */
	public function setStatus($status);

	/**
	 * Appends a new error instance to the generator
	 * @param  JsonError $error 	The error to append
	 * @return JsonErrorGenerator   The JsonErrorGenerator instance
	 */
	public function appendError(JsonError $error);

	/**
	 * Generates a response object containing the specified errors
	 * @return Response
	 */
	public function generateErrorResponse();

	/**
	 * Generates an array containing the specified errors
	 * @return array
	 */
	public function generateErrorJson();
}
