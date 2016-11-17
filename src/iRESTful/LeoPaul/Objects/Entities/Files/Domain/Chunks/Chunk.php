<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;

interface Chunk extends Entity {
	public function getPhysicalFile();
	public function getFutureFileUuid();
	public function getIndex();
	public function attachFile(File $file);
	public function hasFile();
	public function getFile();
}
