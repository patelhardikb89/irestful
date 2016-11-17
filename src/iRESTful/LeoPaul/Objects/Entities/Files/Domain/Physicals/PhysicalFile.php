<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Path;

interface PhysicalFile {
	public function hasPath();
	public function getPath();
	public function hasContent();
	public function getContent();
}
