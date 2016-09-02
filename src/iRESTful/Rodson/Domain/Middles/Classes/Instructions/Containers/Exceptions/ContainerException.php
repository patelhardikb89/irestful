<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Exceptions;

final class ContainerException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
