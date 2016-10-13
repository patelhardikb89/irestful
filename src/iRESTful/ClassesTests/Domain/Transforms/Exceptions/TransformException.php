<?php
namespace iRESTful\ClassesTests\Domain\Transforms\Exceptions;

final class TransformException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
