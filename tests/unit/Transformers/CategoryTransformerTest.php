<?php

use ExpoHub\Category;
use ExpoHub\Transformers\CategoryTransformer;

class CategoryTransformerTest extends TestCase
{
	/** @var CategoryTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new CategoryTransformer;
	}

	/** @test */
	public function it_transforms_category()
	{
		$category = $this->makeCategory();

		$transformedArray = $this->transformer->transform($category);

		$this->assertEquals([
			'id' => 1,
			'name' => 'category-name'
		], $transformedArray);
	}

	/**
	 * @return Category
	 */
	private function makeCategory()
	{
		$category = new Category;
		$category->id = 1;
		$category->name = "category-name";

		return $category;
	}
}