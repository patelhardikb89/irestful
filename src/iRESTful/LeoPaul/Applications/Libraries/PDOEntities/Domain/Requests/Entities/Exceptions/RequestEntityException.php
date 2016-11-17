<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions;

final class RequestEntityException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
