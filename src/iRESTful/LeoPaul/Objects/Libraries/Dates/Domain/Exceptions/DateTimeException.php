<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions;

final class DateTimeException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
