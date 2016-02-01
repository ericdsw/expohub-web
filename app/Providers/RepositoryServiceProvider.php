<?php

namespace ExpoHub\Providers;


use ExpoHub\Repositories\Contracts\CommentRepository as CommentRepositoryContract;
use ExpoHub\Repositories\Contracts\FairRepository as FairRepositoryContract;
use ExpoHub\Repositories\Contracts\CategoryRepository as CategoryRepositoryContract;
use ExpoHub\Repositories\Contracts\EventTypeRepository as EventTypeRepositoryContract;
use ExpoHub\Repositories\Contracts\FairEventRepository as FairEventRepositoryContract;
use ExpoHub\Repositories\Contracts\UserRepository as UserRepositoryContract;
use ExpoHub\Repositories\Contracts\NewsRepository as NewsRepositoryContract;
use ExpoHub\Repositories\Contracts\MapRepository as MapRepositoryContract;
use ExpoHub\Repositories\Contracts\SpeakerRepository as SpeakerRepositoryContract;
use ExpoHub\Repositories\Contracts\SponsorRepository as SponsorRepositoryContract;
use ExpoHub\Repositories\Contracts\SponsorRankRepository as SponsorRankRepositoryContract;

use ExpoHub\Repositories\Eloquent\CategoryRepository;
use ExpoHub\Repositories\Eloquent\CommentRepository;
use ExpoHub\Repositories\Eloquent\FairRepository;
use ExpoHub\Repositories\Eloquent\EventTypeRepository;
use ExpoHub\Repositories\Eloquent\FairEventRepository;
use ExpoHub\Repositories\Eloquent\UserRepository;
use ExpoHub\Repositories\Eloquent\NewsRepository;
use ExpoHub\Repositories\Eloquent\MapRepository;
use ExpoHub\Repositories\Eloquent\SpeakerRepository;
use ExpoHub\Repositories\Eloquent\SponsorRepository;
use ExpoHub\Repositories\Eloquent\SponsorRankRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		app()->bind(FairRepositoryContract::class, FairRepository::class);
		app()->bind(CategoryRepositoryContract::class, CategoryRepository::class);
		app()->bind(CommentRepositoryContract::class, CommentRepository::class);
		app()->bind(EventTypeRepositoryContract::class, EventTypeRepository::class);
		app()->bind(FairEventRepositoryContract::class, FairEventRepository::class);
		app()->bind(UserRepositoryContract::class, UserRepository::class);
		app()->bind(NewsRepositoryContract::class, NewsRepository::class);
		app()->bind(MapRepositoryContract::class, MapRepository::class);
		app()->bind(SpeakerRepositoryContract::class, SpeakerRepository::class);
		app()->bind(SponsorRepositoryContract::class, SponsorRepository::class);
		app()->bind(SponsorRankRepositoryContract::class, SponsorRankRepository::class);
	}
}