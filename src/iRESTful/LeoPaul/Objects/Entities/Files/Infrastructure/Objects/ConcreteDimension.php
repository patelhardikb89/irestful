<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Dimension;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Exceptions\DimensionException;

final class ConcreteDimension implements Dimension {
	private $width;
	private $height;

	/**
    *   @width -> getWidth() -> width
    *   @height -> getHeight() -> height
    */
	public function __construct($width, $height) {

		$width = (int) $width;
		$height = (int) $height;

		if (empty($width)) {
			throw new DimensionException('The width must be a non-empty integer.');
		}

		if (empty($height)) {
			throw new DimensionException('The height must be a non-empty integer.');
		}

		$this->width = $width;
		$this->height = $height;

	}

	public function getWidth() {
		return $this->width;
	}

	public function getHeight() {
		return $this->height;
	}

}
