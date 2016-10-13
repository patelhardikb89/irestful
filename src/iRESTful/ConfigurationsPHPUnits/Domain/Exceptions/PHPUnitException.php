<?php
namespace iRESTful\ConfigurationsPHPUnits\Domain\Exceptions;

final class PHPUnitException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
