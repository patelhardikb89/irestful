<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions;

final class ServerException extends \Exception {

    public function __construct($message) {
        parent::__construct($message);
    }
}
