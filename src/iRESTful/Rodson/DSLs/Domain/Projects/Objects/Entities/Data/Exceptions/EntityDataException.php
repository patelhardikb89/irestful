<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Data\Exceptions;

final class EntityDataException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
