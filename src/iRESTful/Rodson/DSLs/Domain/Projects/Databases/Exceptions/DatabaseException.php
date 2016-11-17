<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Databases\Exceptions;

final class DatabaseException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
