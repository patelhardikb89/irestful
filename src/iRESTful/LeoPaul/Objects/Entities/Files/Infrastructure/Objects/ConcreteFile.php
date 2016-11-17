<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

/**
*   @container -> files
*/
final class ConcreteFile extends AbstractEntity implements File {
	private $physicalFile;
	private $chunks;
	private $sizeInBytes;
	private $mimeType;

	/**
    *   @physicalFile -> getPhysicalFile()->getPath()->getRelative() -> physical_file ** iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters\PhysicalFileAdapter::fromRelativePathStringToPhysicalFile
    *   @chunks -> getChunks() -> chunks ** @type -> iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Chunk
	*   @sizeInBytes -> getSizeInBytes() -> size_in_bytes
    *   @mimeType -> getMimeType() -> mime_type
    */
	public function __construct(Uuid $uuid, \DateTime $createdOn, PhysicalFile $physicalFile, array $chunks, $sizeInBytes, $mimeType) {

		if (is_object($sizeInBytes) || is_array($sizeInBytes)) {
			throw new EntityException('The sizeInBytes must be a non-empty integer.');
		}

		$sizeInBytes = (int) $sizeInBytes;
		if (empty($sizeInBytes)) {
			throw new EntityException('The sizeInBytes must be a non-empty integer.');
		}

		if (!is_string($mimeType) || empty($mimeType)) {
			throw new EntityException('The mimeType must be a non-empty string.');
		}

		if (empty($chunks)) {
            throw new EntityException('The chunks cannot be empty.');
        }

		if (!$this->contains('iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Chunk', $chunks)) {
            throw new EntityException('The chunks array must only contain Chunk objects. At least one of its instances is not a Chunk object.');
        }

		parent::__construct($uuid, $createdOn);
		$this->physicalFile = $physicalFile;
		$this->chunks = $this->orderChunks($chunks);
		$this->sizeInBytes = $sizeInBytes;
		$this->mimeType = $mimeType;
	}

	public function getPhysicalFile() {
		return $this->physicalFile;
	}

	public function getChunks() {
		return $this->chunks;
	}

	public function getSizeInBytes() {
		return $this->sizeInBytes;
	}

	public function getMimeType() {
		return $this->mimeType;
	}

	private function orderChunks(array $chunks) {

		$output = [];
		$indexes = [];
		foreach($chunks as $i => $oneChunk) {
			$smallestChunk = null;
			$smallestIndex = null;
			foreach($chunks as $j => $comparisonChunk) {
				$currentChunkIndex = $oneChunk->getIndex();
				if ($currentChunkIndex <= $comparisonChunk->getIndex() && !in_array($currentChunkIndex, $indexes)) {
					$smallestChunk = $oneChunk;
					$smallestIndex = $currentChunkIndex;
				}
			}

			if (!is_null($smallestIndex)) {
				$output[] = $smallestChunk;
				$indexes[] = $smallestIndex;
			}

		}

		return $output;

	}

}
