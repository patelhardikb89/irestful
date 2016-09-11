<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Exceptions;

final class ControllerException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
