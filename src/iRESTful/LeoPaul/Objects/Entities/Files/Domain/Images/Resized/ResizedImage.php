<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Resized;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface ResizedImage extends Entity {
	public function getImage();
	public function getOriginalImage();
}
