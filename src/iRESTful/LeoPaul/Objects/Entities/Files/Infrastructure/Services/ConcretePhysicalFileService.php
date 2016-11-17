<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Services\PhysicalFileService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Exceptions\PhysicalFileException;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters\PhysicalFileAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Path;

final class ConcretePhysicalFileService implements PhysicalFileService {
	private $physicalFileAdapter;
	private $basePath;
	private $saveToPath;
	public function __construct(PhysicalFileAdapter $physicalFileAdapter, $basePath, $saveToPath) {
		$this->physicalFileAdapter = $physicalFileAdapter;
		$this->basePath = $basePath;
		$this->saveToPath = $saveToPath;
	}

	public function insert(PhysicalFile $file) {

		$content = null;
		$fileName = '';
		$fileExtension = '';
		$timestamp = time();

		if ($file->hasPath()) {
			$path = $file->getPath();
			$fileName = $path->getFileName();
			$fileExtension = $path->hasExtension() ? '.'.$path->getExtension() : '';

			$original = $path->get();
			$content = file_get_contents($original);
		}

		if ($file->hasContent()) {
			$content = $file->getContent();
			$fileName = md5($content);
		}

		if (empty($content)) {
			throw new PhysicalFileException('There is no content to insert in the file.');
		}

		$filePaths = $this->createFilePaths($fileName, $fileExtension, $timestamp);
		if (@file_put_contents($filePaths['absolute'], $content) === false) {
			throw new PhysicalFileException('It was impossible to write content to this file: '.$filePaths['absolute']);
		}

		return $this->physicalFileAdapter->convertDataToPhysicalFile([
			'path' => $filePaths['relative']
		]);

	}

	public function delete(Path $path) {

		$path = $path->get();
		if (@unlink($path) === false) {
			throw new PhysicalFileException('It was impossible to delete the file from this path: '.$path);
		}
	}

	private function createSubFolders($timestamp) {
		return '/'.date('Y/m/d', $timestamp);
	}

	private function createRelativeDirectory($timestamp) {
		return $this->saveToPath.$this->createSubFolders($timestamp);
	}

	private function createAbsoluteDirectory($timestamp) {
		return $this->basePath.$this->createRelativeDirectory($timestamp);
	}

	private function createFilePaths($fileName, $fileExtension, $timestamp) {

		$fileWithExtension = '/'.$fileName.$fileExtension;

		//create directory if not already:
		$relativeDirectory = $this->createRelativeDirectory($timestamp);
		$absoluteDirectory = $this->createAbsoluteDirectory($timestamp);
		if (!is_dir($absoluteDirectory)) {
			if (!@mkdir($absoluteDirectory, 0777, true)) {
				throw new PhysicalFileException('There was a problem while creating the directory ('.$absoluteDirectory.') recursively.');
			}
		}

		return [
			'relative' => $relativeDirectory.$fileWithExtension,
			'absolute' => $absoluteDirectory.$fileWithExtension
		];
	}

}
