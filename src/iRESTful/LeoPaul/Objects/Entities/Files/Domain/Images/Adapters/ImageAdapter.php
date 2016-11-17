<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;

interface ImageAdapter {
	public function fromFileToImage(File $file);
	public function fromPhysicalFileToImage(PhysicalFile $physicalFile);
}
