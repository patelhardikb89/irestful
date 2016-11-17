<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Exceptions;

final class RequestRelationException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
