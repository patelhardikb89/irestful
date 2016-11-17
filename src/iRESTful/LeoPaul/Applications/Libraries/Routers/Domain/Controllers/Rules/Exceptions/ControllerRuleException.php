<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Exceptions;

final class ControllerRuleException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
