<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files\Exceptions;

final class FileException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
