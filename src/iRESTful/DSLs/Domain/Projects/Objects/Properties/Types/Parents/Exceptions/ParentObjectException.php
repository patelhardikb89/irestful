<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Parents\Exceptions;

final class ParentObjectException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
