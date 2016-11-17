<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface File extends Entity {
	public function getPhysicalFile();
	public function getChunks();
	public function getSizeInBytes();
	public function getMimeType();
}
