<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions;

final class ControllerResponseException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
