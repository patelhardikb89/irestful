<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Comparisons\Exceptions;

final class TestInstructionComparisonException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
