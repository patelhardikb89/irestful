<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Adapters\ImageAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Adapters\FileAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteImage;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidFactory;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;

final class ConcreteImageAdapter implements ImageAdapter {
	private $uuidFactory;
	private $fileAdapter;
	public function __construct(UuidFactory $uuidFactory, FileAdapter $fileAdapter) {
		$this->uuidFactory = $uuidFactory;
		$this->fileAdapter = $fileAdapter;
	}

	public function fromPhysicalFileToImage(PhysicalFile $physicalFile) {
		$file = $this->fileAdapter->fromPhysicalFileToFile($physicalFile);
		return $this->fromFileToImage($file);
	}

	public function fromFileToImage(File $file) {

		$uuid = $this->uuidFactory->create();
		$createdOn = $file->createdOn();
		$dimension = $this->fileAdapter->fromFileToDimension($file);

		return new ConcreteImage($uuid, $createdOn, $file, $dimension);
	}

}
