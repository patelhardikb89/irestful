<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Exceptions;

final class DimensionException extends \Exception {
	const CODE = 1;
	public function __construct($message, \Exception $parentException = null) {
		parent::__construct($message, self::CODE, $parentException);
	}
}
