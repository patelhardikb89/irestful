<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Adapters\DimensionAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Exceptions\DimensionException;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteDimension;

final class ConcreteDimensionAdapter implements DimensionAdapter {

	public function __construct() {

	}

	public function fromDataToDimension(array $data) {

		if (isset($data['width']) && isset($data['height'])) {
			return new ConcreteDimension($data['width'], $data['height']);
		}

		if (!isset($data['original_dimension']['width'])) {
			throw new DimensionException('The original_dimension->width keyname is mandatory in order to convert data to a Dimension object, if the width and height is not directly given.');
		}

		if (!isset($data['original_dimension']['height'])) {
			throw new DimensionException('The original_dimension->height keyname is mandatory in order to convert data to a Dimension object, if the width and height is not directly given.');
		}

		if (isset($data['width']) && !isset($data['height'])) {
			$width = (int) $data['width'];
			$ratio = $data['original_dimension']['width'] / $width;
			$height = $data['original_dimension']['height'] / $ratio;

			return new ConcreteDimension($width, $height);
		}

		if (!isset($data['width']) && isset($data['height'])) {
			$height = (int) $data['height'];
			$ratio = $data['original_dimension']['height'] / $height;
			$width = $data['original_dimension']['width'] / $ratio;

			return new ConcreteDimension($width, $height);
		}

		if (isset($data['ratio'])) {
			$ratio = (float) $data['ratio'];
			$width = (int) floor($data['original_dimension']['width'] * $ratio);
			$height = (int) floor($data['original_dimension']['height'] * $ratio);

			return new ConcreteDimension($width, $height);
		}

		throw new DimensionException('The data was invalid.  It was impossible to convert it to a Dimension object.');

	}

}
