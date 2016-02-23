<?php

use Mockery\Mock;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ExpoHub\Helpers\Files\FileManager;
use ExpoHub\Helpers\Generators\Contracts\NameGenerator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;

class FileManagerTest extends TestCase
{
	/** @var FileManager */
	private $fileManager;

	/** @var Mock */
	private $fileSystem;

	/** @var Mock */
	private $imageManager;

	public function setUp()
	{
		parent::setUp();

		$this->fileSystem = $this->mock(Filesystem::class);
		$this->imageManager = $this->mock(ImageManager::class);

		$this->fileManager = new FileManager($this->fileSystem, $this->imageManager, new StubNameGenerator);
	}

	/** @test */
	public function it_uploads_file()
	{
		$extension = 'jpg';
		$folder = 'fooFolder/';
		$randomFileString = '';

		$imageMock = $this->mock(Image::class);
		$uploadedFileMock = $this->mock(UploadedFile::class);

		$uploadedFileMock->shouldReceive('getClientOriginalExtension')
			->withNoArgs()
			->once()
			->andReturn($extension);

		File::shouldReceive('get')
			->with($uploadedFileMock)
			->once()
			->andReturn($randomFileString);

		$this->imageManager->shouldReceive('make')
			->with($randomFileString)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('encode')
			->withAnyArgs()
			->once()
			->andReturn($imageMock);

		$this->fileSystem->shouldReceive('put')
			->once()
			->with('fooFolder/foo.jpg', $randomFileString);

		$resultPath = $this->fileManager->uploadFile($folder, $uploadedFileMock);

		$this->assertEquals('fooFolder/foo.jpg', $resultPath);
	}

	/** @test */
	public function it_deletes_an_existing_file()
	{
		$filePath = 'foo';

		$this->fileSystem->shouldReceive('exists')
			->with($filePath)
			->once()
			->andReturn(true);

		$this->fileSystem->shouldReceive('delete')
			->with($filePath)
			->once();

		$result = $this->fileManager->deleteFile($filePath);

		$this->assertTrue($result);
	}

	/** @test */
	public function it_skips_non_existing_file_deletion()
	{
		$filePath = 'foo';

		$this->fileSystem->shouldReceive('exists')
			->with($filePath)
			->once()
			->andReturn(false);

		$result = $this->fileManager->deleteFile($filePath);

		$this->assertFalse($result);
	}

	/** @test */
	public function it_can_resize_image_with_default_values()
	{
		$randomFileString = 'fooString';
		$imagePath = 'fooFolder/foo.png';		// png will be changed to jpg due to encoding
		$encodedImageData = 'encoded';

		$imageMock = $this->mock(Image::class);
		$imageMock->encoded = $encodedImageData;

		File::shouldReceive('get')
			->with($imagePath)
			->once()
			->andReturn($randomFileString);

		$this->imageManager->shouldReceive('make')
			->with($randomFileString)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('fit')
			->with(650, 650)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('encode')
			->with('jpg', 80)
			->once()
			->andReturn($imageMock);

		$this->fileSystem->shouldReceive('put')
			->with('fooFolder/foo.jpg', $encodedImageData)
			->once();

		$resultPath = $this->fileManager->resizeImage($imagePath);

		$this->assertEquals('fooFolder/foo.jpg', $resultPath);
	}

	/** @test */
	public function it_can_resize_image_with_provided_values()
	{
		$randomFileString = 'fooString';
		$imagePath = 'fooFolder/foo.png';		// png will be changed to jpg due to encoding
		$encodedImageData = 'encoded';

		$providedWidth = 100;
		$providedHeight = 120;
		$providedQuality = 50;

		$imageMock = $this->mock(Image::class);
		$imageMock->encoded = $encodedImageData;

		File::shouldReceive('get')
			->with($imagePath)
			->once()
			->andReturn($randomFileString);

		$this->imageManager->shouldReceive('make')
			->with($randomFileString)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('fit')
			->with($providedWidth, $providedHeight)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('encode')
			->with('jpg', $providedQuality)
			->once()
			->andReturn($imageMock);

		$this->fileSystem->shouldReceive('put')
			->with('fooFolder/foo.jpg', $encodedImageData)
			->once();

		$resultPath = $this->fileManager->resizeImage($imagePath, $providedWidth, $providedHeight, $providedQuality);

		$this->assertEquals('fooFolder/foo.jpg', $resultPath);
	}

	/** @test */
	public function it_can_make_image_thumbnail_with_default_values()
	{
		$randomFileString = 'fooString';
		$imagePath = 'fooFolder/foo.png';		// png will be changed to jpg due to encoding
		$encodedImageData = 'encoded';

		$imageMock = $this->mock(Image::class);
		$imageMock->encoded = $encodedImageData;

		File::shouldReceive('get')
			->with($imagePath)
			->once()
			->andReturn($randomFileString);

		$this->imageManager->shouldReceive('make')
			->with($randomFileString)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('fit')
			->with(FileManager::THUMBNAIL_TARGET_WIDTH, FileManager::THUMBNAIL_TARGET_HEIGHT)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('encode')
			->with(FileManager::THUMBNAIL_DEFAULT_FORMAT, FileManager::THUMBNAIL_DEFAULT_QUALITY)
			->once()
			->andReturn($imageMock);

		$this->fileSystem->shouldReceive('put')
			->with('fooFolder/foo-thumbnail.jpg', $encodedImageData)
			->once();

		$resultPath = $this->fileManager->makeThumbNail($imagePath);

		$this->assertEquals('fooFolder/foo-thumbnail.jpg', $resultPath);
	}

	/** @test */
	public function it_can_make_image_thumbnail_with_provided_values()
	{
		$randomFileString = 'fooString';
		$imagePath = 'fooFolder/foo.png';		// png will be changed to jpg due to encoding
		$thumbnailIdentifier = 'customIdentifier';
		$encodedImageData = 'encoded';

		$imageMock = $this->mock(Image::class);
		$imageMock->encoded = $encodedImageData;

		File::shouldReceive('get')
			->with($imagePath)
			->once()
			->andReturn($randomFileString);

		$this->imageManager->shouldReceive('make')
			->with($randomFileString)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('fit')
			->with(FileManager::THUMBNAIL_TARGET_WIDTH, FileManager::THUMBNAIL_TARGET_HEIGHT)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('encode')
			->with(FileManager::THUMBNAIL_DEFAULT_FORMAT, FileManager::THUMBNAIL_DEFAULT_QUALITY)
			->once()
			->andReturn($imageMock);

		$this->fileSystem->shouldReceive('put')
			->with('fooFolder/foo-customIdentifier.jpg', $encodedImageData)
			->once();

		$resultPath = $this->fileManager->makeThumbNail($imagePath, $thumbnailIdentifier);

		$this->assertEquals('fooFolder/foo-customIdentifier.jpg', $resultPath);
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function it_throws_exception_on_get_width_without_image()
	{
		$this->fileManager->getWidth();
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function it_throws_exception_on_get_height_without_image()
	{
		$this->fileManager->getHeight();
	}

	/** @test */
	public function it_returns_image_width_and_height()
	{
		$extension = 'jpg';
		$folder = 'fooFolder/';
		$randomFileString = '';

		$imageMock = $this->mock(Image::class);
		$uploadedFileMock = $this->mock(UploadedFile::class);

		$imageMock->shouldReceive('width')
			->withNoArgs()
			->andReturn(100);

		$imageMock->shouldReceive('height')
			->withNoArgs()
			->andReturn(100);

		$uploadedFileMock->shouldReceive('getClientOriginalExtension')
			->withNoArgs()
			->once()
			->andReturn($extension);

		File::shouldReceive('get')
			->with($uploadedFileMock)
			->once()
			->andReturn($randomFileString);

		$this->imageManager->shouldReceive('make')
			->with($randomFileString)
			->once()
			->andReturn($this->imageManager);

		$this->imageManager->shouldReceive('encode')
			->withAnyArgs()
			->once()
			->andReturn($imageMock);

		$this->fileSystem->shouldReceive('put')
			->once()
			->with('fooFolder/foo.jpg', $randomFileString);

		$this->fileManager->uploadFile($folder, $uploadedFileMock);

		$width = $this->fileManager->getWidth();
		$height = $this->fileManager->getHeight();

		$this->assertEquals(100, $width);
		$this->assertEquals(100, $height);
	}
}

class StubNameGenerator implements NameGenerator
{
	/**
	 * @param $extension
	 * @return string
	 */
	public function generateUniqueName($extension)
	{
		return 'foo' . '.' . $extension;
	}
}
