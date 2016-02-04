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
		$category = new Category;
		$category->id = 1;
		$category->name = "foo";

		$transformedArray = $this->transformer->transform($category);

		$this->assertEquals(1, $transformedArray['id']);
		$this->assertEquals('foo', $transformedArray['name']);
	}
}