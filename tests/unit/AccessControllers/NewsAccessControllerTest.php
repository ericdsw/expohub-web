<?php

use ExpoHub\AccessControllers\NewsAccessController;
use ExpoHub\Fair;
use ExpoHub\News;
use ExpoHub\Repositories\Contracts\NewsRepository;
use ExpoHub\User;
use Mockery\Mock;
use Tymon\JWTAuth\JWTAuth;

class NewsAccessControllerTest extends TestCase
{
	/** @var Mock|JWTAuth */
	private $jwtAuth;

	/** @var Mock|NewsRepository */
	private $newsRepository;

	/** @var NewsAccessController */
	private $newsAccessController;

	public function setUp()
	{
		parent::setUp();

		$this->jwtAuth = $this->mock(JWTAuth::class);
		$this->newsRepository = $this->mock(NewsRepository::class);

		$this->newsAccessController = new NewsAccessController($this->jwtAuth, $this->newsRepository);
	}

	/** @test */
	public function it_returns_true_if_user_can_create_news_for_fair()
	{
		$fair = new Fair;
		$fair->id = 1;

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

		$result = $this->newsAccessController->canCreateNewsForFair($fair->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_create_news_for_fair()
	{
		$fair = new Fair;
		$fair->id = 1;

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

		$result = $this->newsAccessController->canCreateNewsForFair($fair->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_update_the_news()
	{
		$fair = new Fair;
		$fair->id = 1;

		$news = new News;
		$news->id = 1;
		$news->fair_id = $fair->id;
		$news->setRelation('fair', $fair);

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

		$this->newsRepository->shouldReceive('find')
			->with($news->id)
			->once()
			->andReturn($news);

		$result = $this->newsAccessController->canUpdateNews($news->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_update_the_news()
	{
		$fair = new Fair;
		$fair->id = 1;

		$news = new News;
		$news->id = 1;
		$news->fair_id = $fair->id;
		$news->setRelation('fair', $fair);

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

		$this->newsRepository->shouldReceive('find')
			->with($news->id)
			->once()
			->andReturn($news);

		$result = $this->newsAccessController->canUpdateNews($news->id);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_returns_true_if_user_can_delete_the_news()
	{
		$fair = new Fair;
		$fair->id = 1;

		$news = new News;
		$news->id = 1;
		$news->fair_id = $fair->id;
		$news->setRelation('fair', $fair);

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

		$this->newsRepository->shouldReceive('find')
			->with($news->id)
			->once()
			->andReturn($news);

		$result = $this->newsAccessController->canDeleteNews($news->id);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_returns_false_if_user_cannot_delete_the_news()
	{
		$fair = new Fair;
		$fair->id = 1;

		$news = new News;
		$news->id = 1;
		$news->fair_id = $fair->id;
		$news->setRelation('fair', $fair);

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

		$this->newsRepository->shouldReceive('find')
			->with($news->id)
			->once()
			->andReturn($news);

		$result = $this->newsAccessController->canDeleteNews($news->id);

		$this->assertFalse($result);
	}
}