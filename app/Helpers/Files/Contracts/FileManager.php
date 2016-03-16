<?php

namespace ExpoHub\Helpers\Files\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileManager
{
	/**
	 * @param $folder
	 * @param UploadedFile $file
	 * @return string
	 */
	public function uploadFile($folder, UploadedFile $file);

	/**
	 * @param $filePath
	 * @return string
	 */
	public function deleteFile($filePath);

	/**
	 * @param $imagePath
	 * @param int $targetWidth
	 * @param int $targetHeight
	 * @param int $quality
	 * @return string
	 */
	public function resizeImage($imagePath, $targetWidth = 650, $targetHeight = 650, $quality = 80);

	/**
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