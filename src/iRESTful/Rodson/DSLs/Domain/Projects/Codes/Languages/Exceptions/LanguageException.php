<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Codes\Languages\Exceptions;

final class LanguageException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
