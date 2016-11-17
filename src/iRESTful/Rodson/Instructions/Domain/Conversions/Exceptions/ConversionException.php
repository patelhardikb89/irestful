<?php
namespace iRESTful\Rodson\Instructions\Domain\Conversions\Exceptions;

final class ConversionException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
