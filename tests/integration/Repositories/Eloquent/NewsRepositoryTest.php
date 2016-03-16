<?php


use ExpoHub\News;
use ExpoHub\Repositories\Eloquent\NewsRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NewsRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var NewsRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new NewsRepository(new News);
	}

	/** @test */
	public function it_gets_news_by_fair()
	{
		$user = $this->createUser();
		$fair = $this->createFair($user->id);
		$randomFair = $this->createFair($user->id);

		$this->createNews($fair->id);
		$this->createNews($fair->id);
		$this->createNews($randomFair->id);

		$news = $this->repository->getByFair($fair->id);

		$this->assertCount(2, $news);
	}
}