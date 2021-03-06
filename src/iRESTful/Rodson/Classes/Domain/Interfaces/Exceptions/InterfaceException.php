<?php
namespace iRESTful\Rodson\Classes\Domain\Interfaces\Exceptions;

final class InterfaceException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
