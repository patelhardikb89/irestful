<?php
namespace iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Exceptions;

final class ControllerNodeException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
