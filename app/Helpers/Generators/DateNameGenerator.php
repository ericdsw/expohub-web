<?php
namespace ExpoHub\Helpers\Generators;

use Illuminate\Support\Str;
use ExpoHub\Helpers\Generators\Contracts\NameGenerator;

class DateNameGenerator implements NameGenerator
{
	/**
	 * Generates unique name with specified extension
	 *
	 * @param $extension
	 * @return string
	 */
	public function generateUniqueName($extension)
	{
		return Str::random() . date("Y-m-d-h-i-s") . "." . $extension;
	}
}
