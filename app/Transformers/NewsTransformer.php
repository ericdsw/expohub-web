<?php

namespace ExpoHub\Transformers;


use ExpoHub\News;
use League\Fractal\Resource\Item;

class NewsTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fair'];

	/**
	 * Converts News to json
	 *
	 * @param News $news
	 * @return array
	 */
	public function transform(News $news)
	{
		return [
			'id' => (int) $news->id,
			'title' => $news->title,
			'content' => $news->content,
			'image' => $news->image
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "news";
	}

	/**
	 * Includes related Fair
	 *
	 * @param News $news
	 * @return Item
	 */
	public function includeFair(News $news)
	{
		$fair = $news->fair;
		$fairTransformer = app()->make(FairTransformer::class);
		return $this->item($fair, $fairTransformer, $fairTransformer->getType());
	}
}