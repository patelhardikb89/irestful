<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dimensions\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Adapters\DimensionAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Infrastructure\Objects\ConcreteDimension;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Exceptions\DimensionException;

final class ConcreteDimensionAdapter implements DimensionAdapter {

    public function __construct() {

    }

    public function fromDataToDimension(array $data) {

        if (!isset($data['width'])) {
            throw new DimensionException('The width keyname is mandatory in order to convert data to a Dimension object.');
        }

        if (!isset($data['height'])) {
            throw new DimensionException('The height keyname is mandatory in order to convert data to a Dimension object.');
        }

        $width = (int) $data['width'];
        $height = (int) $data['height'];
        return new ConcreteDimension($width, $height);

    }

}
