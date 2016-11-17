<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;

interface FileAdapter {
	public function fromPhysicalFileToFile(PhysicalFile $physicalFile);
	public function fromFileToDimension(File $file);
}
