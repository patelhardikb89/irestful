<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Adapters\DimensionAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Exceptions\DimensionException;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Adapters\FileAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteFile;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\DateTimeAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Adapters\ChunkAdapter;

final class ConcreteFileAdapter implements FileAdapter {
	private $uuidFactory;
	private $dateTimeAdapter;
	private $chunkAdapter;
	private $dimensionAdapter;
	public function __construct(UuidFactory $uuidFactory, DateTimeAdapter $dateTimeAdapter, ChunkAdapter $chunkAdapter, DimensionAdapter $dimensionAdapter) {
		$this->uuidFactory = $uuidFactory;
		$this->dateTimeAdapter = $dateTimeAdapter;
		$this->chunkAdapter = $chunkAdapter;
		$this->dimensionAdapter = $dimensionAdapter;
	}

	public function fromPhysicalFileToFile(PhysicalFile $physicalFile) {
		$chunk = $this->chunkAdapter->fromPhysicalFileToChunk($physicalFile);
		$uuid = $chunk->getFutureFileUuid();
		$createdOn = $this->dateTimeAdapter->fromTimestampToDateTime(time());

		$sizeInBytes = null;
		$mimeType = null;
		if ($physicalFile->hasPath()) {
			$path = $physicalFile->getPath()->get();
			$sizeInBytes = filesize($path);
			$mimeType = mime_content_type($path);
		}

		if ($physicalFile->hasContent()) {
			$content = $physicalFile->getContent();
			$sizeInBytes = strlen($content);

			$finfo = new \finfo(FILEINFO_MIME);
			$mimeType = $finfo->buffer($content);
		}


		$chunks = [
			$chunk
		];
		return new ConcreteFile($uuid, $createdOn, $physicalFile, $chunks, $sizeInBytes, $mimeType);

	}

	public function fromFileToDimension(File $file) {

		$size = null;
		$physicalFile = $file->getPhysicalFile();
		if ($physicalFile->hasPath()) {
			$path =$physicalFile->getPath()->get();
			$size = getimagesize($path);
		}

		if ($physicalFile->hasContent()) {
			$content = $physicalFile->getContent();
			$size = getimagesizefromstring($content);
		}

		if (!isset($size[0]) || !isset($size[1])) {
			throw new DimensionException('It was not possible to retrieve the dimension of the file ('.$path.').');
		}

		return $this->dimensionAdapter->fromDataToDimension([
			'width' => $size[0],
			'height' => $size[1]
		]);

	}

}
