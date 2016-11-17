<?php
namespace iRESTful\ClassesTests\Domain\CRUDs\Exceptions;

final class CRUDException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
