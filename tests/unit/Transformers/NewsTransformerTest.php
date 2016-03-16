<?php

use ExpoHub\News;
use ExpoHub\Transformers\NewsTransformer;

class NewsTransformerTest extends TestCase
{
	/** @var NewsTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new NewsTransformer;
	}

	/** @test */
	public function it_transforms_news()
	{
		$news = $this->makeNews();

		$transformedArray = $this->transformer->transform($news);

		$this->assertEquals([
			'id' => 1,
			'title' => 'news-title',
			'content' => 'news-content',
			'image' => 'news-image'
		], $transformedArray);
	}

	/**
	 * @return News
	 */
	private function makeNews()
	{
		$news = new News;
		$news->id = 1;
		$news->title = 'news-title';
		$news->content = 'news-content';
		$news->image = 'news-image';

		return $news;
	}
}