<?php
namespace iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Exceptions;

final class ParameterException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, $parentException = null);
    }
}
