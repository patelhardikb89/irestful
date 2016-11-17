<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Exceptions;

final class ClientException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
