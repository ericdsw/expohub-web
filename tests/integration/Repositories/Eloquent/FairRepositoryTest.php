<?php

use Carbon\Carbon;
use ExpoHub\Fair;
use ExpoHub\Repositories\Eloquent\FairRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class FairRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var FairRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new FairRepository(new Fair);
	}

	/** @test */
	public function it_gets_fairs_by_owner_user()
	{
		$user 		= $this->createUser();
		$randomUser = $this->createUser();

		$this->createFair($user->id);		// Valid fair
		$this->createFair($user->id);		// Valid fair
		$this->createFair($randomUser->id);	// Invalid fair, not from user
		$this->createFair($user->id);		// Valid fair

		$fairs = $this->repository->getByUser($user->id);

		$this->assertCount(3, $fairs);
	}

	/** @test */
	public function it_gets_helping_fairs_by_user()
	{
		$user 			= $this->createUser();
		$helpingUser 	= $this->createUser();

		$firstFair 		= $this->createFair($user->id);		// Valid fair
		$secondFair 	= $this->createFair($user->id);		// Valid fair
		$thirdFair 		= $this->createFair($user->id);		// Invalid fair, not helping
		$fourthFair 	= $this->createFair($user->id);		// Invalid fair, helping but banned

		$firstFair->helperUsers()->attach($helpingUser->id);
		$secondFair->helperUsers()->attach($helpingUser->id);
		$fourthFair->helperUsers()->attach($helpingUser->id);

		$fourthFair->bannedUsers()->attach($helpingUser->id);

		$fairs = $this->repository->getHelpingFairsByUser($helpingUser->id);

		$this->assertCount(2, $fairs);
	}

	/** @test */
	public function it_gets_banned_fairs_by_user()
	{
		$user = $this->createUser();
		$bannedUser = $this->createUser();

		$firstFair 		= $this->createFair($user->id);		// Valid fair
		$secondFair 	= $this->createFair($user->id);		// Valid fair
		$thirdFair 		= $this->createFair($user->id);		// Invalid fair, not banned

		$firstFair->bannedUsers()->attach($bannedUser->id);
		$secondFair->bannedUsers()->attach($bannedUser->id);

		$fairs = $this->repository->getBannedFairsByUser($bannedUser->id);

		$this->assertCount(2, $fairs);
	}

	/** @test */
	public function it_gets_active_fairs()
	{
		Carbon::setTestNow(Carbon::now());

		$user = $this->createUser();

		// Valid fair
		$this->createFair($user->id, [
			'starting_date' => Carbon::now()->subDays(5),
			'ending_date' => Carbon::now()->addDays(5)
		]);

		// Valid fair starting today
		$this->createFair($user->id, [
			'starting_date' => Carbon::now(),
			'ending_date' => Carbon::now()->addDays(5)
		]);

		// Valid fair ending today
		$this->createFair($user->id, [
			'starting_date' => Carbon::now()->subDays(2),
			'ending_date' => Carbon::now()
		]);

		// Invalid fair, already ended
		$this->createFair($user->id, [
			'starting_date' => Carbon::now()->subDays(6),
			'ending_date' => Carbon::now()->subDays(3)
		]);

		// Invalid fair, not started yet
		$this->createFair($user->id, [
			'starting_date' => Carbon::now()->addDays(3),
			'ending_date' => Carbon::now()->addDays(6)
		]);

		$fairs = $this->repository->getActiveFairs();

		$this->assertCount(3, $fairs);
	}
}