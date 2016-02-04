<?php

namespace ExpoHub\Transformers;

use ExpoHub\Category;

class CategoryTransformer extends BaseTransformer
{
	public function transform(Category $category)
	{
		return [
			'id' => (int) $category->id,
			'name' => $category->name
		];
	}

	public function getType()
	{
		return "category";
	}
}