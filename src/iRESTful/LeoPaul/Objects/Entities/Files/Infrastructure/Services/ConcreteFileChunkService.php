<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Services\ChunkService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Chunk;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Services\PhysicalFileService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters\PhysicalFileAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteFileChunk;

final class ConcreteFileChunkService implements ChunkService {
	private $entityService;
	private $physicalFileAdapter;
	public function __construct(EntityService $entityService, PhysicalFileService $fileService, PhysicalFileAdapter $physicalFileAdapter) {
		$this->entityService = $entityService;
		$this->physicalFileService = $fileService;
		$this->physicalFileAdapter = $physicalFileAdapter;
	}

	public function insert(Chunk $chunk) {

		$physicalFile = $chunk->getPhysicalFile();
		$createdOn = $chunk->createdOn();

		$relativePath = $physicalFile->getPath()->getRelative();
		$file = $this->physicalFileAdapter->convertDataToPhysicalFile([
			'path' => $relativePath
		]);

		$uuid = $chunk->getUuid();
		$futureFileUuid = $chunk->getFutureFileUuid();
		$index = $chunk->getIndex();

		$fileChunk = new ConcreteFileChunk($uuid, $createdOn, $physicalFile, $futureFileUuid, $index);
		$this->entityService->insert($fileChunk);

		return $fileChunk;

	}

	public function delete(Chunk $chunk) {

		$path = $chunk->getPhysicalFile()->getPath();
		$this->physicalFileService->delete($path);
		$this->entityService->delete($chunk);

	}

}
