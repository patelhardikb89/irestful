<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions;

final class UuidException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
