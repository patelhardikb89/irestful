<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples\References\Exceptions;

final class ReferenceException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
