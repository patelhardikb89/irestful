<?php
namespace iRESTful\Rodson\Domain\Controllers\Exceptions;

final class ControllerException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException) {
        parent:__construct($message, self::CODE, $parentException);
    }
}
