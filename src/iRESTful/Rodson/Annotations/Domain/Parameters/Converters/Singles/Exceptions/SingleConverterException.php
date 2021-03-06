<?php
namespace iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Singles\Exceptions;

final class SingleConverterException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
