<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions;

final class EntityRelationException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
