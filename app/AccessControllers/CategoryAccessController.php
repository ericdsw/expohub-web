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
	 * CategoryAccessController constructor
	 *
	 * @param JWTAuth $jwtAuth
	 * @param CategoryRepository $categoryRepository
	 */
	public function __construct(JWTAuth $jwtAuth, CategoryRepository $categoryRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * Checks if request can create a new category for the specified fair
	 *
	 * @param int $fairId
	 * @return bool
	 */
	public function canCreateCategoryForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()
			->fairs->contains('id', $fairId);
	}

	/**
	 * Checks if request can update category
	 *
	 * @param int $categoryId
	 * @return bool
	 */
	public function canUpdateCategory($categoryId)
	{
		$fairId = $this->categoryRepository->find($categoryId)->fair_id;

		return $this->jwtAuth->parseToken()->toUser()
			->fairs->lists('id')->contains($fairId);
	}

	/**
	 * Checks if request can delete category
	 *
	 * @param int $categoryId
	 * @return bool
	 */
	public function canDeleteCategory($categoryId)
	{
		$fairId = $this->categoryRepository->find($categoryId)->fair_id;

		return $this->jwtAuth->parseToken()->toUser()
			->fairs->lists('id')->contains($fairId);
	}
}
