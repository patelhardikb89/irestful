<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Relations\Exceptions;

final class RelatedEntityException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
