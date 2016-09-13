<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Floats\Exceptions;

final class FloatException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
