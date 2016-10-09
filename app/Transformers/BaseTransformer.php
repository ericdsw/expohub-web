<?php
namespace ExpoHub\Transformers;

use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
	/**
	 * @return string
	 */
	public abstract function getType();
}
