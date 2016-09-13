<?php
namespace iRESTful\Rodson\Domain\Inputs\Authors\Exceptions;

final class AuthorException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
