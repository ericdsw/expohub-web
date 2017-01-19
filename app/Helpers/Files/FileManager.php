<?php
namespace ExpoHub\Helpers\Files;

use File;
use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ExpoHub\Helpers\Files\Contracts\FileManager as FileManagerContract;
use ExpoHub\Helpers\Generators\Contracts\NameGenerator;

class FileManager implements FileManagerContract
{
	const THUMBNAIL_TARGET_WIDTH 	= 50;
	const THUMBNAIL_TARGET_HEIGHT 	= 50;
	const THUMBNAIL_DEFAULT_FORMAT 	= "jpg";
	const THUMBNAIL_DEFAULT_QUALITY = 90;

	private $filesystem;
	private $imageManager;
	private $nameGenerator;

	/** @var Image */
	private $lastManagedImage;

	/**
	 * Default constructor
	 *
	 * @param Filesystem $filesystem
	 * @param ImageManager $imageManager
	 * @param NameGenerator $nameGenerator
	 */
	public function __construct(Filesystem $filesystem, ImageManager $imageManager, NameGenerator $nameGenerator)
	{
		$this->filesystem 		= $filesystem;
		$this->imageManager 	= $imageManager;
		$this->nameGenerator	= $nameGenerator;
	}

	/**
	 * @param $folder
	 * @param UploadedFile $file
	 * @return string
	 */
	public function uploadFile($folder, UploadedFile $file)
	{
		$fileName	= $this->nameGenerator->generateUniqueName($file->getClientOriginalExtension());
		$imageUrl	= $folder . $fileName;

		$this->lastManagedImage = $this->imageManager->make(File::get($file))->encode('jpg', 90);

		$this->filesystem->put($imageUrl, $this->lastManagedImage->encoded);

		return $imageUrl;
	}

	/**
	 * @param $filePath
	 * @return string
	 */
	public function deleteFile($filePath)
	{
		if($this->filesystem->exists($filePath)) {
			$this->filesystem->delete($filePath);
			return true;
		}
		return false;
	}

	/**
	 * @param $imagePath
	 * @param int $targetWidth
	 * @param int $targetHeight
	 * @param int $quality
	 * @return string
	 */
	public function resizeImage($imagePath, $targetWidth = 650, $targetHeight = 650, $quality = 80)
	{
		$file 				= File::get($imagePath);
		$originalExtension 	= pathinfo($imagePath)["extension"];

		$this->lastManagedImage = $this->imageManager->make($file)
			->fit($targetWidth, $targetHeight)
			->encode("jpg", $quality);

		$modifiedPath = dirname($imagePath) . "/" . basename($imagePath, ".{$originalExtension}") . ".jpg";

		$this->filesystem->put($modifiedPath, $this->lastManagedImage->encoded);

		return $modifiedPath;
	}

	/**
	 * @param $imagePath
	 * @param string $nameExtension
	 * @return string
	 */
	public function makeThumbNail($imagePath, $nameExtension = "thumbnail")
	{
		$file 		= File::get($imagePath);
		$extension 	= pathinfo($imagePath)["extension"];

		$this->lastManagedImage = $this->imageManager->make($file)
			->fit(self::THUMBNAIL_TARGET_WIDTH, self::THUMBNAIL_TARGET_HEIGHT)
			->encode(self::THUMBNAIL_DEFAULT_FORMAT, self::THUMBNAIL_DEFAULT_QUALITY);

		$thumbNailPath = dirname($imagePath) . "/" . basename($imagePath, ".{$extension}") . "-{$nameExtension}" . ".jpg";
		$this->filesystem->put($thumbNailPath, $this->lastManagedImage->encoded);

		return $thumbNailPath;
	}

	/**
	 * Get last parsed image
	 *
	 * @return int
	 */
	public function getWidth()
	{
		if(! isset($this->lastManagedImage)) {
			throw new InvalidArgumentException;
		}
		return $this->lastManagedImage->width();
	}

	/**
	 * Get last parsed image height
	 *
	 * @return int
	 */
	public function getHeight()
	{
		if(! isset($this->lastManagedImage)) {
			throw new InvalidArgumentException;
		}
		return $this->lastManagedImage->height();
	}
}
