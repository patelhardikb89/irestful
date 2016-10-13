<?php
namespace iRESTful\TestInstructions\Domain\Exceptions;

final class TestInstructionException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
