<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions;

final class HttpException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
