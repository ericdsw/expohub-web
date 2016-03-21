<?php

namespace ExpoHub\AccessControllers;

use ExpoHub\Repositories\Contracts\NewsRepository;
use Tymon\JWTAuth\JWTAuth;

class NewsAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/** @var NewsRepository */
	private $newsRepository;

	/**
	 * NewsAccessController constructor.
	 * @param JWTAuth $jwtAuth
	 * @param NewsRepository $newsRepository
	 */
	public function __construct(JWTAuth $jwtAuth, NewsRepository $newsRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->newsRepository = $newsRepository;
	}

	/**
	 * @param $fairId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateNewsForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()->fairs
			->contains('id', $fairId);
	}

	/**
	 * @param $newsId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateNews($newsId)
	{
		$fairId = $this->newsRepository->find($newsId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}

	/**
	 * @param $newsId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canDeleteNews($newsId)
	{
		$fairId = $this->newsRepository->find($newsId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()->fairs->lists('id')
			->contains($fairId);
	}
}