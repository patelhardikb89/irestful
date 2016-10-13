<?php
namespace iRESTful\ClassesConverters\Domain\Exceptions;

final class ConverterException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
