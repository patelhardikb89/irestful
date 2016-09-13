<?php
namespace iRESTful\Rodson\Domain\Inputs\Names\Exceptions;

final class NameException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
