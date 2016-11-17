<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidFactory;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Adapters\ChunkAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\DateTimeAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteFileChunk;

final class ConcreteFileChunkAdapter implements ChunkAdapter {
	private $uuidFactory;
	private $dateTimeAdapter;
	public function __construct(UuidFactory $uuidFactory, DateTimeAdapter $dateTimeAdapter) {
		$this->uuidFactory = $uuidFactory;
		$this->dateTimeAdapter = $dateTimeAdapter;
	}

	public function fromPhysicalFileToChunk(PhysicalFile $physicalFile) {
		$uuid = $this->uuidFactory->create();
		$createdOn = $this->dateTimeAdapter->fromTimestampToDateTime(time());
		$futureFileUuid = $this->uuidFactory->create();
		$index = 0;
		return new ConcreteFileChunk($uuid, $createdOn, $physicalFile, $futureFileUuid, $index);

	}

}
