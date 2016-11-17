<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Services;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Path;

interface PhysicalFileService {
	public function insert(PhysicalFile $file);
	public function delete(Path $path);
}
