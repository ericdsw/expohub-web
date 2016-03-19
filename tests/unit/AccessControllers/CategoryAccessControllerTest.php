<?php

use ExpoHub\AccessControllers\CategoryAccessController;
use ExpoHub\Category;
use ExpoHub\Fair;
use ExpoHub\Repositories\Contracts\CategoryRepository;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class CategoryAccessControllerTest extends TestCase
{
	/** @var Mock|CategoryRepository */
	private $categoryRepository;

	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var CategoryAccessController */
	private $categoryAccessController;

	public function setUp()
	{
		parent::setUp();
		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->categoryRepository = $this->mock(CategoryRepository::class);

		$this->categoryAccessController = new CategoryAccessController($this->jwtAuth, $this->categoryRepository);
	}

	/** @test */
	public function it_returns_true_if_user_can_create_category_for_fair()
	{
		$fair = new Fair;
		$fair->id = 2;

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([$fair]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->categoryAccessController->canCreateCategoryForFair($fair->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_create_category_for_fair()
	{
		$fair = new Fair;
		$fair->id = 2;

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$result = $this->categoryAccessController->canCreateCategoryForFair($fair->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_category()
	{
		$fair = new Fair;
		$fair->id = 2;

		$category = new Category;
		$category->id = 3;
		$category->fair_id = $fair->id;
		$category->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([$fair]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->categoryRepository->shouldReceive('find')
			->with($category->id)
			->once()
			->andReturn($category);

		$result = $this->categoryAccessController->canUpdateCategory($category->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_update_category()
	{
		$fair = new Fair;
		$fair->id = 2;

		$category = new Category;
		$category->id = 3;
		$category->fair_id = $fair->id;
		$category->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->categoryRepository->shouldReceive('find')
			->with($category->id)
			->once()
			->andReturn($category);

		$result = $this->categoryAccessController->canUpdateCategory($category->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_delete_category()
	{
		$fair = new Fair;
		$fair->id = 2;

		$category = new Category;
		$category->id = 3;
		$category->fair_id = $fair->id;
		$category->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([$fair]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->categoryRepository->shouldReceive('find')
			->with($category->id)
			->once()
			->andReturn($category);

		$result = $this->categoryAccessController->canDeleteCategory($category->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_delete_category()
	{
		$fair = new Fair;
		$fair->id = 2;

		$category = new Category;
		$category->id = 3;
		$category->fair_id = $fair->id;
		$category->setRelation('fair', $fair);

		$user = new User;
		$user->id = 1;
		$user->setRelation('fairs', collect([]));

		$this->jwtAuth->shouldReceive('parseToken')
			->withNoArgs()
			->once()
			->andReturn($this->jwtAuth);

		$this->jwtAuth->shouldReceive('toUser')
			->withNoArgs()
			->once()
			->andReturn($user);

		$this->categoryRepository->shouldReceive('find')
			->with($category->id)
			->once()
			->andReturn($category);

		$result = $this->categoryAccessController->canDeleteCategory($category->id);

		$this->assertFalse($result);
	}
}