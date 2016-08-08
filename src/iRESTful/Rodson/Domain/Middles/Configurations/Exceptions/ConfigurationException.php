<?php
namespace iRESTful\Rodson\Domain\Middles\Configurations\Exceptions;

final class ConfigurationException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
