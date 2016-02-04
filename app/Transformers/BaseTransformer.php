<?php

namespace ExpoHub\Transformers;


use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
	public abstract function getType();
}