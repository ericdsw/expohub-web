<?php


use ExpoHub\Repositories\Eloquent\SponsorRepository;
use ExpoHub\Sponsor;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SponsorRepositoryTest extends TestCase
{
	use DatabaseMigrations, DatabaseCreator;

	/** @var SponsorRepository */
	private $repository;

	public function setUp()
	{
		parent::setUp();
		$this->repository = new SponsorRepository(new Sponsor);
	}

	/** @test */
	public function it_gets_sponsors_by_fair()
	{
		$user = $this->createUser();
		$fair = $this->createFair($user->id);
		$randomFair = $this->createFair($user->id);
		$sponsorRank = $this->createSponsorRank();

		$this->createSponsor($fair->id, $sponsorRank->id);			// Valid Sponsor
		$this->createSponsor($fair->id, $sponsorRank->id);			// Valid Sponsor
		$this->createSponsor($randomFair->id, $sponsorRank->id);	// Invalid Sponsor, Incorrect fair

		$sponsors = $this->repository->getByFair($fair->id);

		$this->assertCount(2, $sponsors);
	}

	/** @test */
	public function it_gets_sponsors_by_sponsor_ranks()
	{
		$user = $this->createUser();
		$fair = $this->createFair($user->id);
		$sponsorRank = $this->createSponsorRank();
		$randomSponsorRank = $this->createSponsorRank();

		$this->createSponsor($fair->id, $sponsorRank->id);			// Valid Sponsor
		$this->createSponsor($fair->id, $sponsorRank->id);			// Valid Sponsor
		$this->createSponsor($fair->id, $randomSponsorRank->id);	// Invalid Sponsor, Incorrect Sponsor Rank

		$sponsors = $this->repository->getBySponsorRank($sponsorRank->id);

		$this->assertCount(2, $sponsors);
	}
}