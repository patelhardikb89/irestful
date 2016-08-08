<?php
namespace iRESTful\Rodson\Domain\Middles\Tests\Functionals\Transforms\Exceptions;

final class TransformTestException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
