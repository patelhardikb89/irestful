<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\Templates\Exceptions;

final class TemplateException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
