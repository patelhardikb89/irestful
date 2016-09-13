<?php
namespace iRESTful\Rodson\Domain\Inputs\Authors\Emails\Exceptions;

final class EmailException exteds \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
