<?php
namespace iRESTful\Classes\Domain\Constructors\Exceptions;

final class ConstructorException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
