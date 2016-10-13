<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Multiples\Exceptions;

final class MultipleEntityException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
