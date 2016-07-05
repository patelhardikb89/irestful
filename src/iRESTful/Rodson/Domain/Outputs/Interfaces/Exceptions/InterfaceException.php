<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Exceptions;

final class InterfaceException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
