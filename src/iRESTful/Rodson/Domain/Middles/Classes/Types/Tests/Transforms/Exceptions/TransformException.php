<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Exceptions;

final class TransformException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
