<?php
namespace ExpoHub\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'ExpoHub\Events\SomeEvent' => [
            'ExpoHub\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        $events->listen('tymon.jwt.absent', function() {
			return new Response([
				'errors' => [[
					'title' 	=> 'token_not_provided',
					'message' 	=> 'Token not provided for the request',
					'status' 	=> '400'
				]]
			], 400, ['Content-Type' => 'application/vnd.api+json']);
		});

		$events->listen('tymon.jwt.expired', function() {
			return new Response([
				'errors' => [[
					'title' 	=> 'token_expired',
					'message' 	=> 'Token not provided for the request',
					'status' 	=> '401'
				]]
			], 401, ['Content-Type' => 'application/vnd.api+json']);
		});

		$events->listen('tymon.jwt.invalid', function() {
			return new Response([
				'errors' => [[
					'title' 	=> 'token_invalid',
					'message' 	=> 'Token invalid for the request',
					'status' 	=> '500'
				]]
			], 500, ['Content-Type' => 'application/vnd.api+json']);
		});

		$events->listen('tymon.jwt.user_not_found', function() {
			return new Response([
				'errors' => [[
					'title' 	=> 'user_not_found',
					'message' 	=> 'Specified user was not found',
					'status' 	=> '404'
				]]
			], 404, ['Content-Type' => 'application/vnd.api+json']);
		});
    }
}
