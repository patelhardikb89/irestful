<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Methods\Exceptions;

final class MethodException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
