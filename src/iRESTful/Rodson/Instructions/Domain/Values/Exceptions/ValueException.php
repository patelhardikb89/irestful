<?php
namespace iRESTful\Rodson\Instructions\Domain\Values\Exceptions;

final class ValueException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, $parentException);
    }
}
