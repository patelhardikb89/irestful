<?php
namespace iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Exceptions;

final class MetaDataException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
