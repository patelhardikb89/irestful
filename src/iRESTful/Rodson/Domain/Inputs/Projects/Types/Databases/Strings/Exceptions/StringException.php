<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Strings\Exceptions;

final class StringException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
