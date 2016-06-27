<?php
namespace iRESTful\Rodson\Domain\Databases\Relationals\Exceptions;

final class RelationDatabaseException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
