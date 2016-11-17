<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Exceptions;

final class PDOException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
