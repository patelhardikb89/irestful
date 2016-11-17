<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters\PhysicalFileAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Adapters\PathAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcretePhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Exceptions\PhysicalFileException;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Exceptions\PathException;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;

final class ConcretePhysicalFileAdapter implements PhysicalFileAdapter {
	private $pathAdapter;
	public function __construct(PathAdapter $pathAdapter) {
		$this->pathAdapter = $pathAdapter;
	}

	public function fromPhysicalFileToPath(PhysicalFile $physicalFile) {

		if ($physicalFile->hasPath()) {
			return $physicalFile->getPath();
		}

		$content = $physicalFile->getContent();
		return $this->pathAdapter->fromContentToPath($content);

	}

	public function fromContentToPhysicalFile($content) {
		return $this->convertDataToPhysicalFile([
			'content' => $content
		]);
	}

	public function fromRelativePathStringToPhysicalFile($path) {
		return $this->convertDataToPhysicalFile([
			'path' => $path
		]);
	}

	public function convertDataToPhysicalFile(array $data) {

		try {

			$path = null;
			if (isset($data['path'])) {
				$path = $this->pathAdapter->fromRelativePathStringToPath($data['path']);
			}

			$content = null;
			if (isset($data['content'])) {
				$content = $data['content'];
			}

			return new ConcretePhysicalFile($path, $content);

		} catch (PathException $exception) {
			throw new PhysicalFileException('There was an exception while converting a string to a Path object.', $exception);
		}
	}

}
