<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Paths\Exceptions;

final class PathException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
