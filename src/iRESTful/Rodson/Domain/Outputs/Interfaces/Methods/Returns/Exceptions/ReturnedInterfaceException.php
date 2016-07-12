<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Returns\Exceptions;

final class ReturnedInterfaceException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
