<?php

namespace ExpoHub\Transformers;

use ExpoHub\Category;

class CategoryTransformer extends BaseTransformer
{
	/**
	 * Converts Category to valid json representation
	 *
	 * @param Category $category
	 * @return array
	 */
	public function transform(Category $category)
	{
		return [
			'id' => (int) $category->id,
			'name' => $category->name
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "category";
	}
}