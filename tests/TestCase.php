<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

	/**
	 * Returns a mock for the given class and binds it to the service container
	 *
	 * @param $class
	 * @param null $parameters
	 * @return \Mockery\Mock
	 */
	protected function mock($class, $parameters = null)
	{
		$mock = null;
		if($parameters == null) {
			$mock = Mockery::mock($class);
		}
		else {
			$mock = Mockery::mock($class, $parameters);
		}
		$this->app->instance($class, $mock);
		return $mock;
	}

	/**
	 * Removes all registered mocks
	 */
	public function tearDown()
	{
		Mockery::close();
		parent::tearDown();
	}
}
