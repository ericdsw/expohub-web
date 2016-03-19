<?php

namespace ExpoHub\AccessControllers;

use ExpoHub\Repositories\Contracts\CategoryRepository;
use Tymon\JWTAuth\JWTAuth;

class CategoryAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/** @var CategoryRepository */
	private $categoryRepository;

	/**
	 * CategoryAccessController constructor.
	 * @param JWTAuth $jwtAuth
	 * @param CategoryRepository $categoryRepository
	 */
	public function __construct(JWTAuth $jwtAuth, CategoryRepository $categoryRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * @param $fairId
	 * @return boolean
	 */
	public function canCreateCategoryForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()
			->fairs->lists('id')->contains($fairId);
	}

	/**
	 * @param $categoryId
	 * @return boolean
	 */
	public function canUpdateCategory($categoryId)
	{
		$fairId = $this->categoryRepository->find($categoryId)->fair_id;

		return $this->jwtAuth->parseToken()->toUser()
			->fairs->lists('id')->contains($fairId);
	}

	/**
	 * @param $categoryId
	 * @return boolean
	 */
	public function canDeleteCategory($categoryId)
	{
		$fairId = $this->categoryRepository->find($categoryId)->fair_id;

		return $this->jwtAuth->parseToken()->toUser()
			->fairs->lists('id')->contains($fairId);
	}
}