<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Views\Exceptions;

final class ViewException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}