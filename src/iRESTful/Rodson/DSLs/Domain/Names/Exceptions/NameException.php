<?php
namespace iRESTful\Rodson\DSLs\Domain\Names\Exceptions;

final class NameException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
