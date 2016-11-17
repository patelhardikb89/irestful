<?php
namespace iRESTful\Rodson\TestInstructions\Domain\Comparisons\Exceptions;

final class TestInstructionComparisonException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
