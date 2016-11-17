<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Image;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Dimension;

/**
*   @container -> images
*/
final class ConcreteImage extends AbstractEntity implements Image {
	private $file;
	private $dimension;

	/**
    *   @file -> getFile() -> file
    *   @dimension -> getDimension() -> dimension
    */
	public function __construct(Uuid $uuid, \DateTime $createdOn, File $file, Dimension $dimension) {
		parent::__construct($uuid, $createdOn);
		$this->file = $file;
		$this->dimension = $dimension;
	}

	public function getFile() {
		return $this->file;
	}

	public function getDimension() {
		return $this->dimension;
	}

}
