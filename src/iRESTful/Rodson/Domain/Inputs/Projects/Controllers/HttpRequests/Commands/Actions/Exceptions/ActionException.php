<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Actions\Exceptions;

final class ActionException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
