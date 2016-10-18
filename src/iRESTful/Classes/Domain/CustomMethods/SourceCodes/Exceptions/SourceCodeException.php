<?php
namespace iRESTful\Classes\Domain\CustomMethods\SourceCodes\Exceptions;

final class SourceCodeException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
