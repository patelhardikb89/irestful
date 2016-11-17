<?php
namespace iRESTful\Rodson\TestInstructions\Domain\CustomMethods\Nodes\Exceptions;

final class CustomMethodNodeException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
