<?php
namespace iRESTful\Rodson\Domain\Exceptions;

final class RodsonException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
