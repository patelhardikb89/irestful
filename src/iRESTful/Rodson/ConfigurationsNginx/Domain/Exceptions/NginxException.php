<?php
namespace iRESTful\Rodson\ConfigurationsNginx\Domain\Exceptions;

final class NginxException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
