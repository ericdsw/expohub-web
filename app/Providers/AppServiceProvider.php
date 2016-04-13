<?php

namespace ExpoHub\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Serializer\JsonApiSerializer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(app()->environment('local')) {
			app()->register(IdeHelperServiceProvider::class);
		}

		app()->bind(JsonApiSerializer::class, function() {
			return new JsonApiSerializer(url());
		});
    }
}
