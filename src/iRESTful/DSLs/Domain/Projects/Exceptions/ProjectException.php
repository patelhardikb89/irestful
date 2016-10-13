<?php
namespace iRESTful\DSLs\Domain\Projects\Exceptions;

final class ProjectException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
