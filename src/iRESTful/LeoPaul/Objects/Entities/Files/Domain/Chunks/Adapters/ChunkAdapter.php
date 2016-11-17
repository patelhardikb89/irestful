<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;

interface ChunkAdapter {
	public function fromPhysicalFileToChunk(PhysicalFile $physicalFile);
}
