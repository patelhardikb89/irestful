<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions;

final class OrderingException extends \Exception {
	const CODE = 1;
	public function __construct($message, \Exception $parentException = null) {
		parent::__construct($message, self::CODE, $parentException);
	}
}
