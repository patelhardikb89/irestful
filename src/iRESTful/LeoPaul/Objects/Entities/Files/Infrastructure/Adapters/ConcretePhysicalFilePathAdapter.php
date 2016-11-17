<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcretePhysicalFilePath;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Adapters\PathAdapter;

final class ConcretePhysicalFilePathAdapter implements PathAdapter {
	private $basePath;
	private $baseUrl;
	public function __construct($basePath, $baseUrl) {
		$this->basePath = $basePath;
		$this->baseUrl = $baseUrl;
	}

	public function fromContentToPath($content) {
		$timestamp = time();
		$fileName = md5($content);
		$relativeDirectory = '/'.date('Y/m/d', $timestamp);
		return $this->fromRelativePathStringToPath($relativeDirectory);
	}

	public function fromRelativePathStringToPath($path) {

		$directories = explode('/', $path);
		$fileName = array_pop($directories);
		$extension = null;

		$exploded = explode('.', $fileName);
		if (count($exploded) == 2) {
			$fileName = $exploded[0];
			$extension = $exploded[1];
		}

		return new ConcretePhysicalFilePath($this->basePath, $this->baseUrl, $directories, $fileName, $extension);

	}

}
