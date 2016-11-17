<?php
namespace iRESTful\Rodson\DSLs\Domain\SubDSLs\Exceptions;

final class SubDSLException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
