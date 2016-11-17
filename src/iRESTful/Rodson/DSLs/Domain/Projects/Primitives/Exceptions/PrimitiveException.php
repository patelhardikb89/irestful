<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Exceptions;

final class PrimitiveException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
