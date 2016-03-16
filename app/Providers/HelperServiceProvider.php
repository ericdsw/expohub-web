<?php

namespace ExpoHub\Providers;


use ExpoHub\Helpers\Files\Contracts\FileManager as FileManagerContract;
use ExpoHub\Helpers\Files\FileManager;
use ExpoHub\Helpers\Generators\Contracts\NameGenerator;
use ExpoHub\Helpers\Generators\DateNameGenerator;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		app()->bind(FileManagerContract::class, FileManager::class);
		app()->bind(NameGenerator::class, DateNameGenerator::class);
	}
}