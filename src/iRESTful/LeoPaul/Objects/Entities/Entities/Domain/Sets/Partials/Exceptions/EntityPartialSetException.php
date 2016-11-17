<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions;

final class EntityPartialSetException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
