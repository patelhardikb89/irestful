<?php
namespace iRESTful\ConfigurationsVagrants\Domain\Exceptions;

final class VagrantFileException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
