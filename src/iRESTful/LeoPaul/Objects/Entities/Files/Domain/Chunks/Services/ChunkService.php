<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Services;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Chunk;

interface ChunkService {
	public function insert(Chunk $chunk);
	public function delete(Chunk $chunk);
}
