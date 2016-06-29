<?php
namespace iRESTful\Rodson\Domain\Databases\Credentials\Exceptions;

final class CredentialsException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
