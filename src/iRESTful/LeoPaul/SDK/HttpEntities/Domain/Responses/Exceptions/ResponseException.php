<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Exceptions;

final class ResponseException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
