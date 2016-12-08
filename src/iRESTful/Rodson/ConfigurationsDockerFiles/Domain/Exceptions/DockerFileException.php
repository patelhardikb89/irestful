<?php
namespace iRESTful\Rodson\ConfigurationsDockerFiles\Domain\Exceptions;

final class DockerFileException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
