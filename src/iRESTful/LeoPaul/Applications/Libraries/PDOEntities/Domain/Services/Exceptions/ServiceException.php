<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Exceptions;

final class ServiceException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
