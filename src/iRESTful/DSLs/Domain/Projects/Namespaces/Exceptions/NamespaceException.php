<?php
namespace iRESTful\Classes\Domain\Namespaces\Exceptions;

final class NamespaceException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
