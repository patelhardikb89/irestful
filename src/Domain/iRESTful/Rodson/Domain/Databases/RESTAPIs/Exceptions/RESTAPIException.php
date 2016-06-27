<?php
namespace iRESTful\Rodson\Domain\Databases\RESTAPIs\Exceptions;

final class RESTAPIException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
