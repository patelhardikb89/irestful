<?php
namespace iRESTful\DSLs\Domain\Authors\Emails\Exceptions;

final class EmailException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
