<?php
namespace iRESTful\Rodson\Domain\Databases\Relationals\Exceptions;

final class RelationalDatabaseException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
