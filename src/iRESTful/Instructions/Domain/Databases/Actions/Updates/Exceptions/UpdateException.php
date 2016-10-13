<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Updates\Exceptions;

final class UpdateException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
