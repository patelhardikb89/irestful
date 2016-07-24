<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Exceptions;

final class ConstructorException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
