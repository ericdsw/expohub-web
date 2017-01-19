<?php
namespace ExpoHub\Helpers\Generators\Contracts;

interface NameGenerator
{
	/**
	 * Generates an unique filename with the specified extension
	 *
	 * @param $extension
	 * @return string
	 */
	public function generateUniqueName($extension);
}
