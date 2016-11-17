<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dimensions\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Exceptions\DimensionException;
use iRESTful\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Dimension;

final class ConcreteDimension implements Dimension {
    private $width;
    private $height;

    /**
    *   @width -> getWidth() -> width
    *   @height -> getHeight() -> height
    */
    public function __construct($width, $height) {

        if (!is_integer($width)) {
            throw new DimensionException('The width must be an integer.');
        }

        if (!is_integer($height)) {
            throw new DimensionException('The height must be an integer.');
        }

        if (empty($width)) {
            throw new DimensionException('The width ('.$width.') must be greater than 0.');
        }

        if (empty($height)) {
            throw new DimensionException('The height ('.$height.') must be greater than 0.');
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
