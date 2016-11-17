<?php
namespace iRESTful\Rodson\ClassesValues\Domain\Exceptions;

final class ValueException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, \Exception $parentException);
    }
}
