<?php
namespace iRESTful\Rodson\Instructions\Domain\Values\Loops\Exceptions;

final class LoopException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
