<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets\Exceptions;

final class EntityPartialSetException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
