<?php
namespace iRESTful\Rodson\DSLs\Domain\URLs\Exceptions;

final class UrlException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
