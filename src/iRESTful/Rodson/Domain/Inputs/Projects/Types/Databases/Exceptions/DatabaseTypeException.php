<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Exceptions;

final class DatabaseTypeException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
