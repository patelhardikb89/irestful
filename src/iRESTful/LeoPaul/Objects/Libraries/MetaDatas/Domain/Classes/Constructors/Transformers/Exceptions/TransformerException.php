<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions;

final class TransformerException extends \Exception {
	const CODE = 1;
	public function __construct($message, \Exception $parentException = null) {
		parent::__construct($message, self::CODE, $parentException);
	}
}
