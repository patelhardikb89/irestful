<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions;

final class OutputEntityException extends \Exception {
    public function __construct($message, $code) {
        parent::__construct($message, $code);
    }
}
