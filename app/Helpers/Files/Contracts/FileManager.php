<?php
namespace ExpoHub\Helpers\Files\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileManager
{
	/**
	 * Uploads specified file to folder
	 *
	 * @param $folder
	 * @param UploadedFile $file
	 * @return string
	 */
	public function uploadFile($folder, UploadedFile $file);

	/**
	 * Deletes specified file
	 *
	 * @param $filePath
	 * @return string
	 */
	public function deleteFile($filePath);

	/**
	 * Saves a new image reference within specified size
	 *
	 * @param $imagePath
	 * @param int $targetWidth
	 * @param int $targetHeight
	 * @param int $quality
	 * @return string
	 */
	public function resizeImage($imagePath, $targetWidth = 650, $targetHeight = 650, $quality = 80);

	/**
	 * Saves a new image reference with thumbnail size
	 *
	 * @param $imagePath
	 * @param string $nameExtension
	 * @return string
	 */
	public function makeThumbNail($imagePath, $nameExtension = "thumbnail");

	/**
	 * Get last parsed image
	 *
	 * @return int
	 */
	public function getWidth();

	/**
	 * Get last parsed image height
	 *
	 * @return int
	 */
	public function getHeight();
}
