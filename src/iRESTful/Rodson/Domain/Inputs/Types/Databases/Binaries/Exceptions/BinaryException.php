<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Binaries\Exceptions;

final class BinaryException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
