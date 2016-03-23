<?php

namespace ExpoHub\Transformers;


use ExpoHub\News;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class NewsTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fair',
									'comments'];

	/**
	 * Converts News to json
	 *
	 * @param News $news
	 * @return array
	 */
	public function transform(News $news)
	{
		return [
			'id' 		=> (int) $news->id,
			'title' 	=> $news->title,
			'content' 	=> $news->content,
			'image' 	=> $news->imageUrl()
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

	/**
	 * Include related Comments
	 *
	 * @param News $news
	 * @return Collection
	 */
	public function includeComments(News $news)
	{
		$comments = $news->comments;
		$commentTransformer = app()->make(CommentTransformer::class);
		return $this->collection($comments, $commentTransformer, $commentTransformer->getType());
	}
}