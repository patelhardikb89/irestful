<?php
namespace iRESTful\ClassesEntities\Domain\Exceptions;

final class EntityException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
