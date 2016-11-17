<?php
namespace iRESTful\Rodson\ClassesObjects\Domain\Exceptions;

final class ObjectException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
