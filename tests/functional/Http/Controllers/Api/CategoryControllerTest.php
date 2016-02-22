<?php


use ExpoHub\Repositories\Contracts\CategoryRepository;

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
		$this->seeJsonContains(['type' => 'category']);
		$this->dontSeeJson(['type' => 'fair-event']);
		$this->dontSeeJson(['type' => 'fair']);
	}

	/** @test */
	public function it_displays_a_list_of_categories_with_included_fairs()
	{
		$this->get('api/v1/categories?include=fair');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'category']);
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_displays_a_list_of_categories_with_included_fair_events()
	{
		$this->get('api/v1/categories?include=fairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'category']);
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_displays_a_single_category()
	{
		$this->get('api/v1/categories/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'category']);
		$this->dontSeeJson(['type' => 'fair-event']);
		$this->dontSeeJson(['type' => 'fair']);
	}

	/** @test */
	public function it_displays_a_single_category_with_included_fair()
	{
		$this->get('api/v1/categories/1?include=fair');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'category']);
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_displays_a_single_category_with_included_fair_events()
	{
		$this->get('api/v1/categories/1?include=fairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'category']);
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_creates_a_category()
	{
		$this->post('api/v1/categories', $this->createValidStoreRequest());

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'category']);
	}

	/** @test */
	public function it_updates_existing_category()
	{
		$this->put('api/v1/categories/1', $this->createValidUpdateRequest());

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'category']);
	}

	/** @test */
	public function it_destroys_existing_category()
	{
		$this->delete('api/v1/categories/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_displays_categories_by_fair()
	{
		$this->get('api/v1/fairs/1/categories');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'category']);
		$this->dontSeeJson(['type' => 'fair-event']);
	}

	/**
	 * @return array
	 */
	private function createValidStoreRequest()
	{
		return [
			'name' => 'foo',
			'fair_id' => 1
		];
	}

	/**
	 * @return array
	 */
	private function createValidUpdateRequest()
	{
		return ['name' => 'foo'];
	}
}