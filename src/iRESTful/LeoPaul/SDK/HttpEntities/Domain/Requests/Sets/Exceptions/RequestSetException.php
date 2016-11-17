<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Exceptions;

final class RequestSetException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
