<?php
namespace iRESTful\Rodson\Domain\Middles\Applications\Exceptions;

final class ApplicationException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
