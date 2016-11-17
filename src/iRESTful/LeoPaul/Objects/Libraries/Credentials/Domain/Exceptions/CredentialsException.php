<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Credentials\Domain\Exceptions;

final class CredentialsException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
