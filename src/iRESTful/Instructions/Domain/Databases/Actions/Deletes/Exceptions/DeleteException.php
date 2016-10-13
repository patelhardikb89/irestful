<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Deletes\Exceptions;

final class DeleteException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
