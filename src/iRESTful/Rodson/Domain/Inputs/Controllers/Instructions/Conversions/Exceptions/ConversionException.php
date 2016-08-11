<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Conversions\Exceptions;

final class ConversionException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
