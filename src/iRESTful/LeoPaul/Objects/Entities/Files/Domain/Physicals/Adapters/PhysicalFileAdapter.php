<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;

interface PhysicalFileAdapter {
	public function fromPhysicalFileToPath(PhysicalFile $physicalFile);
	public function fromContentToPhysicalFile($content);
	public function fromRelativePathStringToPhysicalFile($path);
	public function convertDataToPhysicalFile(array $data);
}
