<?php
namespace iRESTful\Instructions\Domain\Assignments\Exceptions;

final class AssignmentException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
