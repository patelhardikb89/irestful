<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Resized\Services;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Image;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Dimension;

interface ResizedImageService {
	public function resize(Image $image, Dimension $newDimension);
}
