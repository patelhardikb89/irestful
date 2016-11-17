<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Image;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Resized\ResizedImage;

/**
*   @container -> resized_images
*/
final class ConcreteResizedImage extends AbstractEntity implements ResizedImage {
	private $image;
	private $originalImage;

	/**
    *   @image -> getImage() -> image
    *   @originalImage -> getOriginalImage() -> original_image
    */
	public function __construct(Uuid $uuid, \DateTime $createdOn, Image $image, Image $originalImage) {
		parent::__construct($uuid, $createdOn);
		$this->image = $image;
		$this->originalImage = $originalImage;
	}

	public function getImage() {
		return $this->image;
	}

	public function getOriginalImage() {
		return $this->originalImage;
	}

}
