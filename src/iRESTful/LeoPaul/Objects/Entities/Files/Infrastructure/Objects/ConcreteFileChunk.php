<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Chunk;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;

/**
*   @container -> file_chunks
*/
final class ConcreteFileChunk extends AbstractEntity implements Chunk {
	private $physicalFile;
	private $futureFileUuid;
	private $index;
	private $file;

	/**
    *   @physicalFile -> getPhysicalFile()->getPath()->getRelative() -> physical_file ** iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters\PhysicalFileAdapter::fromRelativePathStringToPhysicalFile
	*   @futureFileUuid -> getFutureFileUuid()->get() || getFutureFileUuid()->getHumanReadable() -> future_file_uuid ** iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidAdapter::fromBinaryStringToUuid || iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidAdapter::fromHumanReadableStringToUuid
	*   @index -> getIndex() -> file_index
    */
	public function __construct(Uuid $uuid, \DateTime $createdOn, PhysicalFile $physicalFile, Uuid $futureFileUuid, $index) {

		$index = (int) $index;

		if ($index < 0) {
			throw new EntityException('The index ('.$index.') must be an integer greater or equal than 0.');
		}

		parent::__construct($uuid, $createdOn);
		$this->physicalFile = $physicalFile;
		$this->futureFileUuid = $futureFileUuid;
		$this->index = $index;
		$this->file = null;
	}

	public function getPhysicalFile() {
		return $this->physicalFile;
	}

	public function getIndex() {
		return $this->index;
	}

	public function getFutureFileUuid() {
		return $this->futureFileUuid;
	}

	public function attachFile(File $file) {
		$this->file = $file;
		return $this;
	}

	public function hasFile() {
		return !empty($this->file);
	}

	public function getFile() {
		return $this->file;
	}

}
