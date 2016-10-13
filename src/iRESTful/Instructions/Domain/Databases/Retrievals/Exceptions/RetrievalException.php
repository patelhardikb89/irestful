<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Exceptions;

final class RetrievalException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
