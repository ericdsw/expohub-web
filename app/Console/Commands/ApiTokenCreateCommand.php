<?php
namespace ExpoHub\Console\Commands;

use ExpoHub\Repositories\Contracts\ApiTokenRepository;
use Illuminate\Console\Command;

class ApiTokenCreateCommand extends Command
{
	/** @var ApiTokenRepository */
	private $apiTokenRepository;

	protected $signature = 'apiToken:create
							{name : the name of the app using this api token}';

	protected $description = 'Creates a new ApiToken to consume the public api';

	/**
	 * ApiTokenCreateCommand constructor.
	 * @param ApiTokenRepository $apiTokenRepository
	 */
	public function __construct(ApiTokenRepository $apiTokenRepository)
	{
		parent::__construct();
		$this->apiTokenRepository = $apiTokenRepository;
	}

	/**
	 * Handles the console command
	 */
	public function handle()
	{
		$name = $this->argument('name');
		$appId = str_random(32);
		$appSecret = str_random(32);

		$this->apiTokenRepository->create([
			'name' => $name,
			'app_id' => $appId,
			'app_secret' => $appSecret
		]);

		$this->info('Created api token with following info: ');
		$this->info('app_id: ' . $appId);
		$this->info('app_secret: ' . $appSecret);
	}
}