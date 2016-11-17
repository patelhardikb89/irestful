<?php
namespace iRESTful\Rodson\Rodson\Domain\Outputs\Methods\Returns\Exceptions;

final class ReturnedInterfaceException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
