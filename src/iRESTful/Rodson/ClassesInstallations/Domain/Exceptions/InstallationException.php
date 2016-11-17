<?php
namespace iRESTful\Rodson\ClassesInstallations\Domain\Exceptions;

final class InstallationException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
