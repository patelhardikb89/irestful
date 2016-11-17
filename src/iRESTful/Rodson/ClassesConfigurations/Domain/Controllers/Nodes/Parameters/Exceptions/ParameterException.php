<?php
namespace iRESTful\Rodson\ClassesConfigurations\Domain\Controllers\Nodes\Parameters\Exceptions;

final class ParameterException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
