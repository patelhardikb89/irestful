<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Transactions\Domain\Exceptions;

final class TransactionException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
