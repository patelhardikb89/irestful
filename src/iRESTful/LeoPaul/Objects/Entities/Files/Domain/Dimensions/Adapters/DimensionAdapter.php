<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;

interface DimensionAdapter {
	public function fromDataToDimension(array $data);
}
