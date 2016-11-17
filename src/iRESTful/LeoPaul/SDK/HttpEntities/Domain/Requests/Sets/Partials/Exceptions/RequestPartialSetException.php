<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Exceptions;

final class RequestPartialSetException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
