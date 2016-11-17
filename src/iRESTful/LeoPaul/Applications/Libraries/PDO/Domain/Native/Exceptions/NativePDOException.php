<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Exceptions;

final class NativePDOException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
