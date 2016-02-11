<?php

namespace ExpoHub\Transformers;

use ExpoHub\Category;
use League\Fractal\Resource\Item;

class CategoryTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fair',
									'fairEvents'];

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

	/**
	 * Includes related Fair
	 *
	 * @param Category $category
	 * @return Item
	 */
	public function includeFair(Category $category)
	{
		$fair = $category->fair;
		$fairTransformer = app()->make(FairTransformer::class);
		return $this->item($fair, $fairTransformer, $fairTransformer->getType());
	}

	public function includeFairEvents(Category $category)
	{
		$fairEvents = $category->fairEvents;
		$fairEventTransformer = app()->make(FairEventTransformer::class);
		return $this->collection($fairEvents, $fairEventTransformer, $fairEventTransformer->getType());
	}
}