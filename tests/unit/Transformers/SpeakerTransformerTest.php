<?php

use ExpoHub\Speaker;
use ExpoHub\Transformers\SpeakerTransformer;

class SpeakerTransformerTest extends TestCase
{
	/** @var SpeakerTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new SpeakerTransformer;
	}

	/** @test */
	public function it_transforms_speaker()
	{
		$speaker = $this->makeSpeaker();

		$transformedArray = $this->transformer->transform($speaker);

		$this->assertEquals([
			'id' => 1,
			'name' => 'speaker-name',
			'picture' => asset('speaker-picture'),
			'description' => 'speaker-description'
		], $transformedArray);
	}

	/**
	 * @return Speaker
	 */
	private function makeSpeaker()
	{
		$speaker = new Speaker;
		$speaker->id = 1;
		$speaker->name = 'speaker-name';
		$speaker->picture = 'speaker-picture';
		$speaker->description = 'speaker-description';

		return $speaker;
	}
}