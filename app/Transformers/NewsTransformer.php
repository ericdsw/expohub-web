<?php

namespace ExpoHub\Transformers;


use ExpoHub\News;

class NewsTransformer extends BaseTransformer
{
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
}