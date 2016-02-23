<?php

namespace ExpoHub\Helpers\Generators\Contracts;

interface NameGenerator
{
	/**
	 * @param $extension
	 * @return string
	 */
	public function generateUniqueName($extension);
}