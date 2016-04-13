<?php

use ExpoHub\AccessControllers\CategoryAccessController;
use ExpoHub\Repositories\Contracts\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(CategoryRepository::class, new StubCategoryRepository);
	}

	/** @test */
	public function it_displays_a_list_of_categories()
	{
		$this->get('api/v1/categories');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'categories']);
		$this->dontSeeJson(['type' => 'fairEvents']);
		$this->dontSeeJson(['type' => 'fairs']);
	}

	/** @test */
	public function it_displays_specific_category()
	{
		$this->get('api/v1/categories/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'categories']);
	}

	/** @test */
	public function it_displays_specific_category_with_includes()
	{
		$includes = 'fair,fairEvents';

		$this->get('api/v1/categories/1?include=' . $includes);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'categories']);
		$this->seeJsonContains(['type' => 'fairEvents']);
		$this->seeJsonContains(['type' => 'fairs']);
	}

	/** @test */
	public function it_returns_not_found_if_category_does_not_exists()
	{
		$this->mock(CategoryRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/categories/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_a_category()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(CategoryAccessController::class)
			->shouldReceive('canCreateCategoryForFair')
			->with(1)
			->once()
			->andReturn(true);

		$this->post('api/v1/categories', $parameters);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'categories']);
	}

	/** @test */
	public function it_returns_unauthorized_on_create_category_if_user_does_not_own_specified_fair()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(CategoryAccessController::class)
			->shouldReceive('canCreateCategoryForFair')
			->with(1)
			->once()
			->andReturn(false);

		$this->post('api/v1/categories', $parameters);

		$this->assertResponseStatus(403);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'forbidden']);
	}

	/** @test */
	public function it_wont_create_category_with_invalid_parameters()
	{
		$this->loginForApi();

		$this->mock(CategoryAccessController::class)
			->shouldReceive('canCreateCategoryForFair')
			->with(1)
			->once()
			->andReturn(true);

		$parameters = [
			// Missing name parameter
			'fair_id' => 1
		];

		$this->post('api/v1/categories', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_wont_create_category_for_not_logged_in_users()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$this->post('api/v1/categories', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_category_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$this->post('api/v1/categories', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_updates_existing_category()
	{
		$parameters = ['name' => 'foo'];

		$this->loginForApi();

		$this->mock(CategoryAccessController::class)
			->shouldReceive('canUpdateCategory')
			->with(1)
			->once()
			->andReturn(true);

		$this->put('api/v1/categories/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'categories']);
	}

	/** @test */
	public function it_returns_unauthorized_on_update_category_if_user_cannot_update_category()
	{
		$parameters = ['name' => 'foo'];

		$this->loginForApi();

		$this->mock(CategoryAccessController::class)
			->shouldReceive('canUpdateCategory')
			->with(1)
			->once()
			->andReturn(false);

		$this->put('api/v1/categories/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_category_for_not_logged_in_users()
	{
		$parameters = ['name' => 'foo'];

		$this->put('api/v1/categories/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_category_for_users_with_expired_session()
	{
		$parameters = ['name' => 'foo'];

		$this->loginForApiWithExpiredToken();

		$this->put('api/v1/categories/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_destroys_existing_category()
	{
		$this->loginForApi();

		$this->mock(CategoryAccessController::class)
			->shouldReceive('canDeleteCategory')
			->with(1)
			->once()
			->andReturn(true);

		$this->delete('api/v1/categories/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_does_not_own_the_related_fair()
	{
		$this->loginForApi();

		$this->mock(CategoryAccessController::class)
			->shouldReceive('canDeleteCategory')
			->with(1)
			->once()
			->andReturn(false);

		$this->delete('api/v1/categories/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_category_for_not_logged_in_users()
	{
		$this->delete('api/v1/categories/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_category_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/categories/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_displays_categories_by_fair()
	{
		$this->get('api/v1/fairs/1/categories');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'categories']);
		$this->dontSeeJson(['type' => 'fair-event']);
	}
}