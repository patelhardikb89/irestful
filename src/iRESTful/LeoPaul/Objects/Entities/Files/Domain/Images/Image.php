<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface Image {
	public function getFile();
	public function getDimension();
}
