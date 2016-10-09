<?php
namespace ExpoHub\Console\Commands;

use ExpoHub\Constants\UserType;
use ExpoHub\Repositories\Contracts\UserRepository;
use Illuminate\Console\Command;

class AdminCreateCommand extends Command
{
	/** @var UserRepository */
	private $userRepository;

	/**
	 * AdminCreateCommand constructor
	 *
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserRepository $userRepository)
	{
		parent::__construct();
		$this->userRepository = $userRepository;
	}

	/**
	 * The name and signature of the console command
	 *
	 * @var string
	 */
	protected $signature = 'admin:create
                            {email : The email of the new admin user}
                            {username : The username of the new admin user}
                            {--password= : The password of the new admin user}';

	/**
	 * The console command description
	 *
	 * @var string
	 */
	protected $description = 'Creates a new admin user';

	/**
	 * Handles the console command
	 */
	public function handle()
	{
		$password = $this->option('password');

		$this->info('Creating user with provided parameters...');
		$this->userRepository->create([
			'name' 		=> 'admin',
			'email' 	=> $this->argument('email'),
			'username'  => $this->argument('username'),
			'password' 	=> ($password == null) ? bcrypt('admin') : bcrypt($password),
			'user_type'	=> UserType::TYPE_ADMIN
		]);
		$this->info('User created!');
	}
}
