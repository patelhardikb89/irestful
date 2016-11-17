<?php
namespace iRESTful\Rodson\Applications\Domain\Domains\Exceptions;

final class DomainException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
