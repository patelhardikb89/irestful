<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Path;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Exceptions\PathException;

final class ConcretePhysicalFilePath implements Path {
	private $basePath;
	private $baseUrl;
	private $path;
	private $fileName;
	private $directories;
	private $extension;
	public function __construct($basePath, $baseUrl, array $directories, $fileName, $extension = null) {

		if (!is_string($basePath) || empty($basePath)) {
			throw new PathException('The basePath must be a non-empty string.');
		}

		if (!is_string($baseUrl) || empty($baseUrl)) {
			throw new PathException('The baseUrl must be a non-empty string.');
		}

		if (!is_string($fileName) || empty($fileName)) {
			throw new PathException('The filename must be a non-empty string.');
		}

		if (!is_string($extension) && !empty($extension)) {
			throw new PathException('The extension must be a string if not empty.');
		}

		$ext = (empty($extension)) ? '' : '.'.$extension;
		$relativePath = implode('/', $directories).'/'.$fileName.$ext;
		$path = $basePath.$relativePath;
		if (!file_exists($path)) {
			throw new PathException('The given path ('.$path.') does not point to a valid file.');
		}

		$url = $baseUrl.$relativePath;
		if (filter_var($url, FILTER_VALIDATE_URL) === false) {
			throw new PathException('The given url ('.$url.') is not a valid url.');
		}

		$this->path = $relativePath;
		$this->fileName = $fileName;
		$this->directories = $directories;
		$this->extension = $extension;
		$this->basePath = $basePath;
		$this->baseUrl = $baseUrl;

	}

	public function get() {
		return $this->basePath.$this->path;
	}

	public function getRelative() {
		return $this->path;
	}

	public function getFileName() {
		return $this->fileName;
	}

	public function getDirectories() {
		return $this->directories;
	}

	public function getUrl() {
		return $this->baseUrl.$this->path;
	}

	public function hasExtension() {
		return !empty($this->extension);
	}

	public function getExtension() {
		return $this->extension;
	}

}
