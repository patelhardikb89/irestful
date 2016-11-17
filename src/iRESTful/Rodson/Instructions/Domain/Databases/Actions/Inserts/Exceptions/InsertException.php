<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Actions\Inserts\Exceptions;

final class InsertException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
