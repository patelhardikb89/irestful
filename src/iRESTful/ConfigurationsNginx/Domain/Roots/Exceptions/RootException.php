<?php
namespace iRESTful\ConfigurationsNginx\Domain\Roots\Exceptions;

final class RootException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
