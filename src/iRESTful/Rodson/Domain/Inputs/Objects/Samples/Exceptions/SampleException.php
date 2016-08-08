<?php
namespace iRESTful\Rodson\Domain\Inputs\Objects\Samples\Exceptions;

final class SampleException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
