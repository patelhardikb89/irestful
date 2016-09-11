<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Exceptions;

final class FromException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
