<?php
namespace iRESTful\Rodson\Instructions\Domain\Values\Loops\Keynames\Exceptions;

final class KeynameException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
