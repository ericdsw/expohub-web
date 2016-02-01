<?php

namespace integration\Repositories\Eloquent;


use DatabaseCreator;
use ExpoHub\Category;
use ExpoHub\Repositories\Eloquent\CategoryRepository;
use ExpoHub\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TestCase;

class CategoryRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var CategoryRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new CategoryRepository(new Category, new User);
	}

	/** @test */
	public function it_returns_categories_by_specified_fair()
	{
		$user = $this->createUser();
		$fair = $this->createFair($user->id);
		$randomFair = $this->createFair($user->id);

		$this->createCategory($fair->id);			// Valid Category
		$this->createCategory($fair->id);			// Valid Category
		$this->createCategory($randomFair->id);		// Invalid Category (different fair)

		$categories = $this->repository->getByFair($fair->id);

		$this->assertCount(2, $categories);
	}

	/** @test */
	public function it_returns_categories_by_specified_user()
	{
		$user 		= $this->createUser();
		$randomUser = $this->createUser();
		$firstFair 	= $this->createFair($user->id);
		$secondFair = $this->createFair($user->id);
		$randomFair = $this->createFair($randomUser->id);

		$this->createCategory($firstFair->id);		// Valid Category
		$this->createCategory($firstFair->id);		// Valid Category
		$this->createCategory($secondFair->id);		// Valid Category
		$this->createCategory($randomFair->id);		// Invalid Category (different user)

		$categories = $this->repository->getByUser($user->id);

		$this->assertCount(3, $categories);
	}
}