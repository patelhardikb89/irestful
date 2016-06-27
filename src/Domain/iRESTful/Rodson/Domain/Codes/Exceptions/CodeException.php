<?php
namespace iRESTful\Rodson\Domain\Codes\Exceptions;

final class CodeException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
